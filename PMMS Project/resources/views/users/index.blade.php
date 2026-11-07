@extends('layouts.app')

@section('title', 'إدارة المستخدمين والأدوار')

@section('content')
<div class="space-y-6 pb-12" x-data="userManagementHub()">

    @if (isset($errors) && $errors->any())
        <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-700 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-2 text-rose-700 dark:text-rose-300 font-bold text-xs mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>يرجى تصحيح الأخطاء التالية:</span>
            </div>
            <ul class="list-disc list-inside text-xs text-rose-700 dark:text-rose-300 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. Header & Overview Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-50 via-white to-indigo-50/40 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-5 md:p-6 border border-slate-200 dark:border-slate-700/80 shadow-xs">
        <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -top-12 w-56 h-56 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-4">

            <!-- Title & Badges & Icon -->
            <div class="flex items-center gap-3.5 flex-wrap">
                <div style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important; color: #ffffff !important;"
                     class="w-12 h-12 rounded-2xl text-white flex items-center justify-center shadow-md shadow-indigo-500/25 shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>

                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-lg sm:text-xl lg:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight font-readex">
                            إدارة المستخدمين والأدوار
                        </h1>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-indigo-500/10 text-indigo-700 dark:text-indigo-300 border border-indigo-500/20">
                            محرك الهوية والأمان
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                            {{ $users->total() }} مستخدم
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium max-w-2xl leading-relaxed">
                        إدارة حسابات المستخدمين وصور الملفات الشخصية، وتعيين الأدوار الوظيفية والصلاحيات المباشرة بدقة متناهية.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap self-start xl:self-center">
                @can('roles.manage')
                    <a href="{{ route('roles.index') }}"
                        class="inline-flex items-center gap-2 h-10 px-4 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md hover:scale-[1.02]">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>مركز الصلاحيات والأدوار</span>
                    </a>
                @endcan

                <button @click="showUserModal = true"
                    class="btn-pill-indigo inline-flex items-center gap-2.5 h-10 pr-4 pl-2 rounded-full text-xs font-bold transition-all shrink-0 cursor-pointer border border-transparent shadow-md hover:scale-[1.02]">
                    <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="whitespace-nowrap px-0.5 text-white font-bold">إضافة مستخدم جديد</span>
                    <span class="badge-pill-yellow text-slate-950 w-6 h-6 min-w-[24px] rounded-full inline-flex items-center justify-center font-black text-sm shrink-0">+</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Statistics KPI Cards (بطاقات المؤشرات السريعة) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Users --}}
        <div class="bg-white dark:bg-slate-800/90 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shrink-0">
                👥
            </div>
            <div>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">إجمالي المستخدمين</span>
                <span class="text-xl font-black font-readex text-slate-800 dark:text-slate-100">{{ $users->total() }}</span>
            </div>
        </div>

        {{-- Total Roles --}}
        <div class="bg-white dark:bg-slate-800/90 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0">
                🛡️
            </div>
            <div>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">الأدوار المتاحة</span>
                <span class="text-xl font-black font-readex text-slate-800 dark:text-slate-100">{{ $roles->count() }}</span>
            </div>
        </div>

        {{-- System Permissions --}}
        <div class="bg-white dark:bg-slate-800/90 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shrink-0">
                🔑
            </div>
            <div>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">صلاحيات المنظومة</span>
                <span class="text-xl font-black font-readex text-slate-800 dark:text-slate-100">{{ $allPermissions->count() }}</span>
            </div>
        </div>

        {{-- Direct Matrix Modules --}}
        <div class="bg-white dark:bg-slate-800/90 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0">
                ⚡
            </div>
            <div>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">القطاعات المحمية</span>
                <span class="text-xl font-black font-readex text-slate-800 dark:text-slate-100">{{ count($modules) }} قطاعات</span>
            </div>
        </div>
    </div>

    <!-- 3. Users Table Container -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 font-black border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="p-4 text-center w-12">#</th>
                        <th class="p-4 text-center w-16">الصورة</th>
                        <th class="p-4">المستخدم</th>
                        <th class="p-4">البريد الإلكتروني</th>
                        <th class="p-4">الدور الوظيفي / المستوى</th>
                        <th class="p-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-slate-700 dark:text-slate-200 font-medium">
                    @foreach ($users as $index => $user)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition">
                            <td class="p-4 text-center text-slate-400 font-bold font-readex">{{ $users->firstItem() + $index }}</td>

                            {{-- عمود الصورة مع مؤشر الحالة --}}
                            <td class="p-4 text-center">
                                <div class="relative inline-block">
                                    <img src="{{ $user->avatar_url }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.svg') }}';"
                                        alt="{{ $user->name }}"
                                        class="w-11 h-11 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shadow-sm bg-slate-100 dark:bg-slate-700">
                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-800"></span>
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="font-black text-slate-900 dark:text-slate-100 text-sm font-readex">{{ $user->name }}</div>
                                <div class="text-[10.5px] text-slate-400 font-mono mt-0.5">ID: #{{ $user->id }}</div>
                            </td>

                            <td class="p-4 text-slate-600 dark:text-slate-400 font-mono font-bold">{{ $user->email }}</td>

                            <td class="p-4">
                                <div class="flex flex-col space-y-1">
                                    @php
                                        $userRole = $user->getRoleNames()->first();
                                        $roleMeta = $userRole
                                            ? \App\Services\PermissionRegistry::getRoleMetadata($userRole)
                                            : null;
                                    @endphp
                                    <span class="px-3 py-1 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-bold text-xs border border-indigo-200 dark:border-indigo-800 inline-flex items-center gap-1.5 w-fit shadow-2xs">
                                        <span>🛡️</span>
                                        <span>{{ $roleMeta['label'] ?? ($userRole ?? 'بدون دور') }}</span>
                                    </span>
                                    @if ($user->permissions->count() > 0)
                                        <span class="text-[10.5px] text-emerald-600 dark:text-emerald-400 font-bold">
                                            + {{ $user->permissions->count() }} صلاحية مباشرة مخصصة
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                        @click="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->getRoleNames()->first() ?? '') }}', '{{ addslashes($user->avatar_url) }}')"
                                        class="px-3 py-1.5 bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 hover:bg-blue-600 hover:text-white border border-blue-200 dark:border-blue-800 font-bold rounded-xl text-xs transition inline-flex items-center gap-1 cursor-pointer shadow-2xs"
                                        title="تعديل المستخدم">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>تعديل</span>
                                    </button>

                                    <button type="button"
                                        @click="openPermissionsModal({{ $user->id }}, '{{ addslashes($user->name) }}', {{ json_encode($user->permissions->pluck('name')->toArray()) }})"
                                        class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-600 hover:text-white border border-emerald-200 dark:border-emerald-800 font-bold rounded-xl text-xs transition inline-flex items-center gap-1 cursor-pointer shadow-2xs"
                                        title="الصلاحيات المباشرة">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        <span>الصلاحيات</span>
                                    </button>

                                    <button type="button"
                                        @click="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                        class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 hover:bg-rose-600 hover:text-white border border-rose-200 dark:border-rose-800 font-bold rounded-xl text-xs transition inline-flex items-center gap-1 cursor-pointer shadow-2xs"
                                        title="حذف المستخدم">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>حذف</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- 4. Modal for Adding User -->
    <div x-show="showUserModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md" x-cloak>
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 border border-slate-200 dark:border-slate-800 text-xs">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold">👤</span>
                    <h3 class="font-black text-sm text-slate-800 dark:text-slate-100 font-readex">إضافة حساب مستخدم جديد</h3>
                </div>
                <button @click="showUserModal = false" class="text-slate-400 hover:text-slate-600 text-lg leading-none cursor-pointer">&times;</button>
            </div>

            <form id="create-user-form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">صورة المستخدم الشخصية</label>
                    <input type="file" name="avatar" accept="image/*"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 file:ml-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition cursor-pointer">
                    <span class="text-[10px] text-slate-400 mt-1 block">صورة اختيارية بتنسيق JPG, PNG, WEBP</span>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="مثال: م. أحمد محمد علي"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="example@domain.com"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">كلمة المرور</label>
                    <input type="password" name="password" required
                        placeholder="••••••••"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">الدور والصلاحية</label>
                    <select name="role" required
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        @foreach ($roles as $r)
                            @php $meta = \App\Services\PermissionRegistry::getRoleMetadata($r->name); @endphp
                            <option value="{{ $r->name }}" {{ old('role') == $r->name ? 'selected' : '' }}>
                                {{ $meta['label'] }} ({{ $r->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-2">
                    <button type="button" @click="showUserModal = false"
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold rounded-xl cursor-pointer">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md cursor-pointer transition">إنشاء الحساب</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 5. Modal for Editing User -->
    <div x-show="editUserId !== null"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md" x-cloak>
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 border border-slate-200 dark:border-slate-800 text-xs">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">✏️</span>
                    <h3 class="font-black text-sm text-slate-800 dark:text-slate-100 font-readex">تعديل بيانات المستخدم</h3>
                </div>
                <button @click="editUserId = null" class="text-slate-400 hover:text-slate-600 text-lg leading-none cursor-pointer">&times;</button>
            </div>

            <form id="edit-user-form" method="POST" x-bind:action="'{{ url('users') }}/' + editUserId" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800/70 p-3 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <img :src="editUserAvatarUrl" alt="صورة المستخدم"
                        class="w-12 h-12 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs flex-shrink-0 bg-slate-100 dark:bg-slate-800">
                    <div class="flex-1 min-w-0">
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">تغيير الصورة الشخصية</label>
                        <input type="file" name="avatar" accept="image/*"
                            class="w-full text-xs rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 file:ml-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-600 file:text-white">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل</label>
                    <input type="text" name="name" required x-model="editUserName"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" required x-model="editUserEmail"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">كلمة المرور الجديدة (اتركها فارغة للإبقاء على الحالية)</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">الدور والصلاحية</label>
                    <select name="role" required x-model="editUserRole"
                        class="w-full text-xs rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                        @foreach ($roles as $r)
                            @php $meta = \App\Services\PermissionRegistry::getRoleMetadata($r->name); @endphp
                            <option value="{{ $r->name }}">
                                {{ $meta['label'] }} ({{ $r->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-2">
                    <button type="button" @click="editUserId = null"
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold rounded-xl cursor-pointer">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md cursor-pointer transition">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 6. Modal for Managing User Direct Permissions -->
    <div x-show="permUserId !== null"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md" x-cloak>
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full p-6 shadow-2xl space-y-4 border border-slate-200 dark:border-slate-800 text-xs max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">🔑</span>
                    <h3 class="font-black text-sm text-slate-800 dark:text-slate-100 font-readex">
                        إدارة الصلاحيات المباشرة للمستخدم: <span class="text-emerald-600 dark:text-emerald-400" x-text="permUserName"></span>
                    </h3>
                </div>
                <button @click="permUserId = null" class="text-slate-400 hover:text-slate-600 text-lg leading-none cursor-pointer">&times;</button>
            </div>

            <form id="perm-user-form" method="POST" x-bind:action="'{{ url('users') }}/' + permUserId + '/permissions'" class="space-y-4 flex-1 overflow-y-auto pr-1">
                @csrf
                @method('PATCH')

                <p class="text-slate-500 dark:text-slate-400 text-xs">
                    الصلاحيات المحددة هنا تُمنح للمستخدم بالإضافة إلى الصلاحيات الموروثة من دوره الوظيفي.
                </p>

                <div class="space-y-4">
                    @foreach ($modules as $moduleKey => $module)
                        <div class="bg-slate-50 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                            <div class="font-black text-xs text-slate-800 dark:text-slate-200 mb-2 flex items-center gap-1.5">
                                <span>📌</span>
                                <span>{{ $module['name'] }}</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach ($module['permissions'] as $permKey => $permData)
                                    @php $pLabel = is_array($permData) ? ($permData['label'] ?? $permKey) : $permData; @endphp
                                    <label class="flex items-center gap-2 p-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-emerald-500 transition">
                                        <input type="checkbox" name="permissions[]" value="{{ $permKey }}"
                                            :checked="userPerms.includes('{{ $permKey }}')"
                                            class="w-4 h-4 text-emerald-600 rounded border-slate-300 dark:border-slate-600 focus:ring-emerald-500">
                                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $pLabel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-slate-900 py-2">
                    <button type="button" @click="permUserId = null"
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold rounded-xl cursor-pointer">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md cursor-pointer transition">حفظ الصلاحيات</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 7. Modal for Delete Confirmation -->
    <div x-show="deleteUserId !== null"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md" x-cloak>
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-4 border border-slate-200 dark:border-slate-800 text-xs text-center">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-2xl mx-auto">
                ⚠️
            </div>
            <div>
                <h3 class="font-black text-sm text-slate-900 dark:text-slate-100 font-readex">تأكيد حذف الحساب</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">
                    هل أنت متأكد من حذف حساب المستخدم <strong class="text-rose-600 font-readex" x-text="deleteUserName"></strong>؟
                </p>
            </div>

            <form id="delete-user-form" method="POST" x-bind:action="'{{ url('users') }}/' + deleteUserId" class="flex justify-center gap-2 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteUserId = null"
                    class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold rounded-xl cursor-pointer">إلغاء</button>
                <button type="submit"
                    class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-md cursor-pointer transition">نعم، حذف الحساب</button>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function userManagementHub() {
        return {
            showUserModal: false,
            editUserId: null,
            editUserName: '',
            editUserEmail: '',
            editUserRole: '',
            editUserAvatarUrl: '',
            permUserId: null,
            permUserName: '',
            userPerms: [],
            deleteUserId: null,
            deleteUserName: '',

            openEditModal(id, name, email, role, avatarUrl) {
                this.editUserId = id;
                this.editUserName = name;
                this.editUserEmail = email;
                this.editUserRole = role;
                this.editUserAvatarUrl = avatarUrl;
            },

            openPermissionsModal(id, name, permissions) {
                this.permUserId = id;
                this.permUserName = name;
                this.userPerms = permissions || [];
            },

            openDeleteModal(id, name) {
                this.deleteUserId = id;
                this.deleteUserName = name;
            }
        }
    }
</script>
@endpush
@endsection
