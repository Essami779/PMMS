<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Governorate;
use App\Models\Currency;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('id')->get();
        $governorates = Governorate::orderBy('id')->get();
        $currencies = Currency::orderBy('sort_order')->orderBy('id')->get();

        return view('lookups.index', compact(
            'units',
            'governorates',
            'currencies'
        ));
    }

    // ==========================================
    // 1. إدارة الوحدات والأقسام الإدارية (Units)
    // ==========================================
    public function storeUnit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'code' => 'nullable|string|max:50|unique:units,code',
            'color_code' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'اسم الوحدة/القسم مطلوب.',
            'name.unique' => 'اسم الوحدة/القسم موجود بالفعل.',
            'code.unique' => 'كود الوحدة موجود بالفعل.',
        ]);

        $validated['color_code'] = $validated['color_code'] ?? 'indigo';
        Unit::create($validated);

        return redirect()->route('lookups.index', ['tab' => 'units'])
            ->with('success', 'تم إضافة القسم/الوحدة الإدارية بنجاح.');
    }

    public function updateUnit(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id,
            'code' => 'nullable|string|max:50|unique:units,code,' . $unit->id,
            'color_code' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'اسم الوحدة/القسم مطلوب.',
            'name.unique' => 'اسم الوحدة/القسم موجود بالفعل.',
            'code.unique' => 'كود الوحدة موجود بالفعل.',
        ]);

        $unit->update($validated);

        return redirect()->route('lookups.index', ['tab' => 'units'])
            ->with('success', 'تم تحديث بيانات الوحدة/القسم بنجاح.');
    }

    public function destroyUnit(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('lookups.index', ['tab' => 'units'])
            ->with('success', 'تم نقل الوحدة/القسم إلى سلة المهملات بنجاح.');
    }

    // ==========================================
    // 2. إدارة المحافظات والمناطق (Governorates)
    // ==========================================
    public function storeGovernorate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:governorates,name',
            'code' => 'nullable|string|max:50|unique:governorates,code',
            'color_code' => 'nullable|string|max:50',
        ], [
            'name.required' => 'اسم المحافظة/المنطقة مطلوب.',
            'name.unique' => 'اسم المحافظة/المنطقة موجود بالفعل.',
            'code.unique' => 'رمز المحافظة موجود بالفعل.',
        ]);

        $validated['color_code'] = $validated['color_code'] ?? 'blue';
        Governorate::create($validated);

        return redirect()->route('lookups.index', ['tab' => 'governorates'])
            ->with('success', 'تم إضافة المحافظة/المنطقة بنجاح.');
    }

    public function updateGovernorate(Request $request, Governorate $governorate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:governorates,name,' . $governorate->id,
            'code' => 'nullable|string|max:50|unique:governorates,code,' . $governorate->id,
            'color_code' => 'nullable|string|max:50',
        ], [
            'name.required' => 'اسم المحافظة/المنطقة مطلوب.',
            'name.unique' => 'اسم المحافظة/المنطقة موجود بالفعل.',
            'code.unique' => 'رمز المحافظة موجود بالفعل.',
        ]);

        $governorate->update($validated);

        return redirect()->route('lookups.index', ['tab' => 'governorates'])
            ->with('success', 'تم تحديث بيانات المحافظة/المنطقة بنجاح.');
    }

    public function destroyGovernorate(Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->route('lookups.index', ['tab' => 'governorates'])
            ->with('success', 'تم نقل المحافظة/المنطقة إلى سلة المهملات بنجاح.');
    }

    // ==========================================
    // 3. إدارة العملات وأسعار الصرف (Currencies)
    // ==========================================
    public function storeCurrency(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:20',
            'flag' => 'nullable|string|max:10',
            'color_code' => 'nullable|string|max:50',
            'hex_color' => 'nullable|string|max:20',
            'exchange_rate' => 'required|numeric|min:0.0001',
            'sort_order' => 'nullable|integer',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'code.required' => 'رمز العملة مطلوب (مثل USD, SAR).',
            'code.unique' => 'رمز العملة موجود مسبقاً.',
            'name.required' => 'اسم العملة مطلوب.',
            'symbol.required' => 'رمز عرض العملة مطلوب.',
            'exchange_rate.required' => 'سعر الصرف مطلوب.',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['color_code'] = $validated['color_code'] ?? 'emerald';
        $validated['is_default'] = $request->has('is_default');
        $validated['is_active'] = $request->has('is_active') ? true : ($request->filled('is_active') ? (bool) $request->is_active : true);

        if ($validated['is_default']) {
            Currency::where('is_default', true)->update(['is_default' => false]);
            $validated['exchange_rate'] = 1.0000;
        }

        Currency::create($validated);

        return redirect()->route('lookups.index', ['tab' => 'currencies'])
            ->with('success', 'تمت إضافة العملة بنجاح.');
    }

    public function updateCurrency(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:20',
            'flag' => 'nullable|string|max:10',
            'color_code' => 'nullable|string|max:50',
            'hex_color' => 'nullable|string|max:20',
            'exchange_rate' => 'required|numeric|min:0.0001',
            'sort_order' => 'nullable|integer',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'code.required' => 'رمز العملة مطلوب.',
            'code.unique' => 'رمز العملة موجود مسبقاً.',
            'name.required' => 'اسم العملة مطلوب.',
            'symbol.required' => 'رمز عرض العملة مطلوب.',
            'exchange_rate.required' => 'سعر الصرف مطلوب.',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_default'] = $request->has('is_default');
        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_default']) {
            Currency::where('id', '!=', $currency->id)->update(['is_default' => false]);
            $validated['exchange_rate'] = 1.0000;
        }

        $currency->update($validated);

        return redirect()->route('lookups.index', ['tab' => 'currencies'])
            ->with('success', 'تم تحديث بيانات العملة بنجاح.');
    }

    public function destroyCurrency(Currency $currency)
    {
        if ($currency->is_default) {
            return redirect()->route('lookups.index', ['tab' => 'currencies'])
                ->with('error', 'لا يمكن حذف العملة الافتراضية للنظام.');
        }

        $currency->delete();
        return redirect()->route('lookups.index', ['tab' => 'currencies'])
            ->with('success', 'تم نقل العملة إلى سلة المهملات بنجاح.');
    }
}
