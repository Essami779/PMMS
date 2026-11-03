<div x-data="{
        query: '',
        isOpen: false,
        isLoading: false,
        results: {},
        totalCount: 0,
        selectedIndex: -1,
        flatItems: [],
        fullSearchUrl: '',
        mobileSearchOpen: false,
        debounceTimer: null,

        init() {
            window.addEventListener('keydown', (e) => {
                // Ctrl+K or Cmd+K
                if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                    e.preventDefault();
                    this.openSearch();
                }
                // Slash (/) when not focusing another input
                if (e.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    this.openSearch();
                }
                // Esc to close
                if (e.key === 'Escape') {
                    this.closeSearch();
                }
            });
        },

        openSearch() {
            this.isOpen = true;
            this.$nextTick(() => {
                if (this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                    this.$refs.searchInput.select();
                }
            });
        },

        closeSearch() {
            this.isOpen = false;
            this.mobileSearchOpen = false;
            this.selectedIndex = -1;
        },

        performSearch() {
            clearTimeout(this.debounceTimer);
            const q = this.query.trim();
            if (q.length < 1) {
                this.results = {};
                this.totalCount = 0;
                this.flatItems = [];
                this.isLoading = false;
                return;
            }

            this.isLoading = true;
            this.debounceTimer = setTimeout(() => {
                fetch(`{{ route('global.search') }}?q=${encodeURIComponent(q)}&ajax=1`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.results = data.categories || {};
                    this.totalCount = data.total_count || 0;
                    this.fullSearchUrl = data.full_search_url || '';

                    // Flatten items for keyboard navigation
                    let list = [];
                    Object.values(this.results).forEach(cat => {
                        if (cat.items && cat.items.length) {
                            cat.items.forEach(item => {
                                list.push(item);
                            });
                        }
                    });
                    this.flatItems = list;
                    this.selectedIndex = list.length > 0 ? 0 : -1;
                    this.isLoading = false;
                    this.isOpen = true;
                })
                .catch(err => {
                    console.error('Search error:', err);
                    this.isLoading = false;
                });
            }, 200);
        },

        selectNext() {
            if (this.flatItems.length === 0) return;
            this.selectedIndex = (this.selectedIndex + 1) % this.flatItems.length;
            this.scrollToItem(this.selectedIndex);
        },

        selectPrev() {
            if (this.flatItems.length === 0) return;
            this.selectedIndex = (this.selectedIndex - 1 + this.flatItems.length) % this.flatItems.length;
            this.scrollToItem(this.selectedIndex);
        },

        handleEnter() {
            if (this.selectedIndex >= 0 && this.flatItems[this.selectedIndex]) {
                window.location.href = this.flatItems[this.selectedIndex].url;
            } else if (this.query.trim().length > 0) {
                window.location.href = `{{ route('global.search') }}?q=${encodeURIComponent(this.query.trim())}`;
            }
        },

        scrollToItem(index) {
            this.$nextTick(() => {
                const el = document.getElementById('search-result-item-' + index);
                if (el) {
                    el.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            });
        },

        clearSearch() {
            this.query = '';
            this.results = {};
            this.totalCount = 0;
            this.flatItems = [];
            this.selectedIndex = -1;
            if (this.$refs.searchInput) {
                this.$refs.searchInput.focus();
            }
        }
    }"
    class="relative flex-1 max-w-2xl mx-2 sm:mx-4 lg:mx-6"
    @click.outside="closeSearch()">

    <!-- Desktop Search Input Container (Spotlight Command Bar) -->
    <div class="relative w-full group">
        <div class="relative flex items-center">
            <!-- Search Icon / Loading Spinner (Right Side in RTL) -->
            <div style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: 10;">
                <svg x-show="!isLoading" style="width: 19px; height: 19px; display: block;" class="text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <svg x-show="isLoading" x-cloak style="width: 19px; height: 19px;" class="animate-spin text-amber-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <!-- The Search Input -->
            <input
                x-ref="searchInput"
                type="text"
                x-model="query"
                @input="performSearch()"
                @focus="if (query.trim().length > 0) isOpen = true"
                @keydown.down.prevent="selectNext()"
                @keydown.up.prevent="selectPrev()"
                @keydown.enter.prevent="handleEnter()"
                placeholder="بحث شامل في المذكرات، الشيكات، الخزينة، السلفيات، والتقارير..."
                style="padding-right: 42px !important; padding-left: 95px !important; text-align: right; direction: rtl;"
                class="w-full h-11 rounded-2xl bg-slate-100/90 dark:bg-slate-800/90 hover:bg-slate-100 dark:hover:bg-slate-800 focus:bg-white dark:focus:bg-slate-900 border-2 border-slate-200/90 dark:border-slate-700/80 focus:border-amber-500 dark:focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 transition-all duration-300 shadow-2xs focus:shadow-md outline-none"
                autocomplete="off"
                spellcheck="false">

            <!-- Clear Button and Shortcut Badge (Left Side - Physically Locked via style) -->
            <div style="position: absolute; left: 10px; right: auto; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 6px; z-index: 10; direction: ltr;">
                <!-- Clear Button -->
                <button
                    x-show="query.length > 0"
                    x-cloak
                    @click="clearSearch()"
                    type="button"
                    style="display: flex; align-items: center; justify-content: center; padding: 4px; border-radius: 8px;"
                    class="text-slate-400 hover:text-rose-500 hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer"
                    title="مسح البحث">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Shortcut Badge (Ctrl+K) -->
                <kbd style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 10px; font-size: 10.5px; font-weight: 800; font-family: monospace; user-select: none; pointer-events: none;" class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 shadow-xs">
                    <span style="font-size: 9.5px; font-family: sans-serif; opacity: 0.8;">Ctrl</span>
                    <span>K</span>
                </kbd>
            </div>
        </div>
    </div>

    <!-- Live Search Results Dropdown Panel -->
    <div
        x-show="isOpen && query.trim().length > 0"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1 scale-98"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-1 scale-98"
        class="absolute left-0 right-0 top-full mt-2 w-full max-w-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xl overflow-hidden z-50 transition-all duration-200 divide-y divide-slate-100 dark:divide-slate-800/80">

        <!-- Results Scroll Area -->
        <div class="max-h-[68vh] overflow-y-auto custom-scrollbar p-2 space-y-4">

            <!-- Category Groups Loop -->
            @php $currentFlatIdx = 0; @endphp
            <template x-for="(catData, catKey) in results" :key="catKey">
                <div class="space-y-1.5" x-show="catData.items && catData.items.length > 0">
                    
                    <!-- Category Header -->
                    <div class="flex items-center justify-between px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <!-- Category Color Pill -->
                            <span class="w-2 h-2 rounded-full"
                                :class="{
                                    'bg-indigo-500': catData.color === 'indigo',
                                    'bg-blue-500': catData.color === 'blue',
                                    'bg-emerald-500': catData.color === 'emerald',
                                    'bg-amber-500': catData.color === 'amber',
                                    'bg-purple-500': catData.color === 'purple',
                                    'bg-cyan-500': catData.color === 'cyan'
                                }"></span>
                            <span x-text="catData.title" class="font-bold text-slate-700 dark:text-slate-300"></span>
                        </div>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400" x-text="catData.items.length + ' نتيجة'"></span>
                    </div>

                    <!-- Items in Category -->
                    <div class="space-y-1">
                        <template x-for="(item, itemIdx) in catData.items" :key="item.id">
                            <a
                                :href="item.url"
                                :id="'search-result-item-' + flatItems.findIndex(x => x.id === item.id)"
                                @mouseenter="selectedIndex = flatItems.findIndex(x => x.id === item.id)"
                                class="group flex items-center justify-between p-2.5 rounded-xl transition-all duration-150 text-right cursor-pointer"
                                :class="selectedIndex === flatItems.findIndex(x => x.id === item.id)
                                    ? 'bg-amber-500/10 dark:bg-amber-500/15 border border-amber-500/30'
                                    : 'hover:bg-slate-100/80 dark:hover:bg-slate-800/80 border border-transparent'">
                                
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <!-- Item Icon -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 transition"
                                        :class="{
                                            'bg-indigo-100 dark:bg-indigo-950/70 text-indigo-600 dark:text-indigo-400': catData.color === 'indigo',
                                            'bg-blue-100 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400': catData.color === 'blue',
                                            'bg-emerald-100 dark:bg-emerald-950/70 text-emerald-600 dark:text-emerald-400': catData.color === 'emerald',
                                            'bg-amber-100 dark:bg-amber-950/70 text-amber-600 dark:text-amber-400': catData.color === 'amber',
                                            'bg-purple-100 dark:bg-purple-950/70 text-purple-600 dark:text-purple-400': catData.color === 'purple',
                                            'bg-cyan-100 dark:bg-cyan-950/70 text-cyan-600 dark:text-cyan-400': catData.color === 'cyan'
                                        }">
                                        
                                        <!-- Compass Icon (Navigation) -->
                                        <template x-if="catKey === 'navigation'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20zm3.5 6.5l-2 5.5-5.5 2 2-5.5 5.5-2z" />
                                            </svg>
                                        </template>

                                        <!-- Document Icon (Memos) -->
                                        <template x-if="catKey === 'memos'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </template>

                                        <!-- Credit Card / Checks Icon -->
                                        <template x-if="catKey === 'checks'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </template>

                                        <!-- Treasury Cash Icon -->
                                        <template x-if="catKey === 'treasury'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </template>

                                        <!-- Loans Icon -->
                                        <template x-if="catKey === 'loans'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </template>

                                        <!-- Archive Icon -->
                                        <template x-if="catKey === 'archive'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </template>
                                    </div>

                                    <!-- Title & Subtitle Group -->
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100 truncate group-hover:text-amber-600 dark:group-hover:text-amber-400 transition" x-text="item.title"></p>
                                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-200/80 dark:bg-slate-800 text-slate-600 dark:text-slate-400 shrink-0" x-text="item.badge"></span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate mt-0.5" x-text="item.subtitle"></p>
                                    </div>
                                </div>

                                <!-- Left Side Meta info and Arrow -->
                                <div class="flex items-center gap-2 shrink-0 mr-3 text-left">
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 whitespace-nowrap hidden sm:inline" x-text="item.meta"></span>
                                    <svg class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-amber-500 group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Empty State (No Results) -->
            <div x-show="!isLoading && totalCount === 0 && query.trim().length > 0" class="py-10 text-center px-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">
                    لم يتم العثور على أي نتائج مطابقة
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                    لم نجد أي سجلات تطابق "<span class="font-bold text-amber-600 dark:text-amber-400" x-text="query"></span>". تأكد من كتابة رقم الشيك أو المذكرة أو الاسم بشكل صحيح.
                </p>
            </div>

        </div>

        <!-- Dropdown Footer Action Bar -->
        <div class="px-4 py-2.5 bg-slate-50/90 dark:bg-slate-800/60 flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <a
                    :href="'{{ route('global.search') }}?q=' + encodeURIComponent(query.trim())"
                    class="font-black text-amber-600 dark:text-amber-400 hover:underline flex items-center gap-1">
                    <span>عرض كافة النتائج في صفحة مستقلة</span>
                    <span x-show="totalCount > 0" class="px-1.5 py-0.2 rounded-full text-[10px] bg-amber-500/20" x-text="'(' + totalCount + ')'"></span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            </div>

            <div class="hidden sm:flex items-center gap-3 text-[11px] text-slate-400 dark:text-slate-500">
                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-[10px]">↑</kbd><kbd class="px-1 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-[10px]">↓</kbd> للتنقل</span>
                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-[10px]">Enter</kbd> للفتح</span>
                <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-[10px]">Esc</kbd> للإغلاق</span>
            </div>
        </div>

    </div>

</div>
