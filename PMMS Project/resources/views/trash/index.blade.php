@extends('layouts.app')

@section('title', 'سلة المهملات والمحذوفات الشاملة')

@section('content')
    <div class="space-y-6 pb-12 w-full max-w-7xl mx-auto" dir="rtl" x-data="trashManager({{ json_encode($items ? $items->pluck('id')->toArray() : []) }})">

        <!-- 1. Header Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-rose-500/10 via-rose-500/5 to-white dark:from-rose-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-sm">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30 flex items-center justify-center shadow-xs shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white tracking-tight font-readex">
                                سلة المهملات والمحذوفات
                            </h1>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                {{ number_format($counts['all'] ?? 0) }} عنصر محذوف
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                            استرجاع السجلات المحذوفة مؤقتاً (الأقسام والوحدات، المحافظات، والعملات) أو حذفها نهائياً.
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2.5 flex-wrap">
                    @if (($counts[$activeTab] ?? 0) > 0)
                        <form method="POST" action="{{ route('trash.empty', $activeTab) }}"
                            onsubmit="return confirm('تحذير: هل أنت متأكد من رغبتك في إفراغ سلة مهملات هذا القسم بالكامل؟ هذا الإجراء سيحذف البيانات نهائياً ولا يمكن التراجع عنه!');">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs rounded-xl transition-all shadow-md flex items-center gap-2 cursor-pointer hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>إفراغ سلة مهملات القسم</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Tabs Bar -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <a href="{{ route('trash.index', ['tab' => 'units']) }}"
                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition flex items-center gap-2 border {{ $activeTab === 'units' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md font-black' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-200 dark:border-slate-700 hover:bg-slate-50' }}">
                <span>🏢 الوحدات والأقسام</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeTab === 'units' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                    {{ $counts['units'] ?? 0 }}
                </span>
            </a>

            <a href="{{ route('trash.index', ['tab' => 'governorates']) }}"
                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition flex items-center gap-2 border {{ $activeTab === 'governorates' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md font-black' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-200 dark:border-slate-700 hover:bg-slate-50' }}">
                <span>📍 المحافظات</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeTab === 'governorates' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                    {{ $counts['governorates'] ?? 0 }}
                </span>
            </a>

            <a href="{{ route('trash.index', ['tab' => 'currencies']) }}"
                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition flex items-center gap-2 border {{ $activeTab === 'currencies' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md font-black' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-200 dark:border-slate-700 hover:bg-slate-50' }}">
                <span>💰 العملات</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeTab === 'currencies' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                    {{ $counts['currencies'] ?? 0 }}
                </span>
            </a>
        </div>

        <!-- 3. Records Table -->
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs">
            @if ($items && $items->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 border-b border-slate-100 dark:border-slate-700">
                                <th class="py-3 px-3">#</th>
                                <th class="py-3 px-3">اسم العنصر</th>
                                <th class="py-3 px-3">الرمز / الكود</th>
                                <th class="py-3 px-3">تاريخ الحذف</th>
                                <th class="py-3 px-3 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                            @foreach ($items as $item)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-750/50 transition">
                                    <td class="py-3.5 px-3 text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="py-3.5 px-3 font-bold text-slate-800 dark:text-slate-100">
                                        {{ $item->name }}
                                    </td>
                                    <td class="py-3.5 px-3">
                                        <span class="font-mono px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                            {{ $item->code ?? ($item->symbol ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-3 text-slate-400 text-[11px]">
                                        {{ $item->deleted_at?->locale('ar')->diffForHumans() }}
                                    </td>
                                    <td class="py-3.5 px-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Restore Single -->
                                            <form method="POST" action="{{ route('trash.restore', ['type' => $activeTab, 'id' => $item->id]) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-300 font-bold text-xs transition flex items-center gap-1 cursor-pointer"
                                                    title="استعادة">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    <span>استعادة</span>
                                                </button>
                                            </form>

                                            <!-- Force Delete Single -->
                                            <form method="POST" action="{{ route('trash.forceDestroy', ['type' => $activeTab, 'id' => $item->id]) }}"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف النهائي لهذا السجل؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400 font-bold text-xs transition flex items-center gap-1 cursor-pointer"
                                                    title="حذف نهائي">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>حذف نهائي</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            @else
                <div class="py-16 text-center text-slate-400 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-700/60 text-slate-400 flex items-center justify-center mx-auto text-xl">
                        🗑️
                    </div>
                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300">سلة المهملات فارغة</p>
                    <p class="text-xs text-slate-400">لا توجد سجلات محذوفة مؤقتاً في هذا القسم حالياً.</p>
                </div>
            @endif
        </div>

    </div>

    <script>
        function trashManager(allIds) {
            return {
                selectedIds: [],
                allIds: allIds || [],
                get allSelected() {
                    return this.allIds.length > 0 && this.selectedIds.length === this.allIds.length;
                },
                toggleAll(e) {
                    if (e.target.checked) {
                        this.selectedIds = [...this.allIds];
                    } else {
                        this.selectedIds = [];
                    }
                }
            }
        }
    </script>
@endsection
