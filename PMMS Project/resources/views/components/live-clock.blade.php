<div class="sidebar-clock-box w-full max-w-[240px] mx-auto p-2 select-none" 
     x-data="{
         timeHours: '12',
         timeMinutes: '00',
         timeSeconds: '00',
         timeAmPm: 'AM',
         dateText: '',
         hourDeg: 0,
         minuteDeg: 0,
         secondDeg: 0,
         updateClock() {
             const now = new Date();
             const arabicMonths = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
             const arabicDays = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

             let hours = now.getHours();
             const minutes = now.getMinutes();
             const seconds = now.getSeconds();

             this.timeAmPm = hours >= 12 ? 'PM' : 'AM';
             const displayHours = hours % 12 || 12;

             this.timeHours = String(displayHours).padStart(2, '0');
             this.timeMinutes = String(minutes).padStart(2, '0');
             this.timeSeconds = String(seconds).padStart(2, '0');

             const day = arabicDays[now.getDay()];
             const date = now.getDate();
             const month = arabicMonths[now.getMonth()];
             const year = now.getFullYear();
             this.dateText = `${day}، ${date} ${month} ${year}`;

             this.secondDeg = seconds * 6;
             this.minuteDeg = (minutes * 6) + (seconds * 0.1);
             this.hourDeg = (displayHours * 30) + (minutes * 0.5);
         },
         init() {
             this.updateClock();
             setInterval(() => this.updateClock(), 1000);
         }
     }" 
     x-init="init()">

    <!-- ================= 1. البطاقة الرقمية (Digital Clock Card) ================= -->
    <div class="p-3 rounded-2xl border digital-clock-card shadow-xs flex flex-col items-center justify-center space-y-2.5">
        
        <!-- كبسولات الوقت المنفصلة (LTR) -->
        <div dir="ltr" class="flex items-center justify-center gap-1.5 font-mono">
            
            <!-- كبسولة الساعات -->
            <span class="w-9 h-8 rounded-xl font-mono font-black text-sm flex items-center justify-center shadow-xs digital-clock-pill"
                  x-text="timeHours" id="clock-hours">12</span>

            <!-- النقطتان الفاصلتان الأولى -->
            <span class="text-blue-600 dark:text-blue-400 font-black text-sm leading-none animate-pulse">:</span>

            <!-- كبسولة الدقائق -->
            <span class="w-9 h-8 rounded-xl font-mono font-black text-sm flex items-center justify-center shadow-xs digital-clock-pill"
                  x-text="timeMinutes" id="clock-minutes">00</span>

            <!-- النقطتان الفاصلتان الثانية -->
            <span class="text-blue-600 dark:text-blue-400 font-black text-sm leading-none animate-pulse">:</span>

            <!-- كبسولة الثواني (تدرج أزرق ملكي بارز) -->
            <span style="background: linear-gradient(135deg, #2563eb, #1d4ed8) !important; color: #ffffff !important; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);"
                  class="w-9 h-8 rounded-xl font-mono font-black text-sm flex items-center justify-center text-white"
                  x-text="timeSeconds" id="clock-seconds">00</span>

            <!-- كبسولة AM / PM -->
            <span class="px-2.5 h-8 rounded-xl font-black text-xs flex items-center justify-center font-mono ml-0.5 shadow-2xs digital-clock-ampm"
                  x-text="timeAmPm" id="clock-ampm">AM</span>
        </div>

        <!-- شريط التاريخ أسفل الكبسولات -->
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-[11px] font-bold digital-clock-date shadow-2xs">
            <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span id="clock-date-text" x-text="dateText">اليوم، التاريخ الحالي</span>
        </div>

    </div>

    <!-- ================= 2. ساعة العقارب التناظرية الفاخرة (3D Analog Clock) ================= -->
    <div class="pt-3 pb-1 flex items-center justify-center">
        <div class="relative w-36 h-36 flex items-center justify-center">
            <svg viewBox="0 0 200 200" class="w-full h-full" style="filter: drop-shadow(0 6px 14px rgba(0,0,0,0.09));">

                <!-- قاعدة وقرص الساعة الدائري -->
                <circle cx="100" cy="100" r="95" stroke-width="4.5" class="analog-dial-base" />
                <circle cx="100" cy="100" r="91" stroke-width="2" class="analog-dial-inner" />

                <!-- خطوط وتدريجات الـ 60 دقيقة والثانية -->
                <g stroke-linecap="round">
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(0, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(6, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(12, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(18, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(24, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(30, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(36, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(42, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(48, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(54, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(60, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(66, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(72, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(78, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(84, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(90, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(96, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(102, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(108, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(114, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(120, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(126, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(132, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(138, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(144, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(150, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(156, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(162, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(168, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(174, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(180, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(186, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(192, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(198, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(204, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(210, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(216, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(222, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(228, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(234, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(240, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(246, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(252, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(258, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(264, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(270, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(276, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(282, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(288, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(294, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(300, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(306, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(312, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(318, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(324, 100, 100)" />
                    <line x1="100" y1="11" x2="100" y2="20" stroke-width="2.8" class="analog-tick-hour" transform="rotate(330, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(336, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(342, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(348, 100, 100)" />
                    <line x1="100" y1="14" x2="100" y2="20" stroke-width="1.2" class="analog-tick-min" transform="rotate(354, 100, 100)" />
                </g>

                <!-- أرقام الساعات الـ 12 -->
                <g font-family="Cairo, Tajawal, sans-serif" font-size="16" font-weight="900" text-anchor="middle" dominant-baseline="central" class="analog-dial-number">
                    <text x="100" y="36">12</text>
                    <text x="133" y="45">1</text>
                    <text x="157" y="69">2</text>
                    <text x="166" y="101">3</text>
                    <text x="157" y="133">4</text>
                    <text x="133" y="157">5</text>
                    <text x="100" y="166">6</text>
                    <text x="67" y="157">7</text>
                    <text x="43" y="133">8</text>
                    <text x="34" y="101">9</text>
                    <text x="43" y="69">10</text>
                    <text x="67" y="45">11</text>
                </g>

                <!-- عقرب الساعات (Hour Hand) -->
                <line x1="100" y1="100" x2="100" y2="52" stroke-width="7" stroke-linecap="round" 
                      class="analog-hand-hour" id="hand-hour" :transform="`rotate(${hourDeg}, 100, 100)`" />

                <!-- عقرب الدقائق (Minute Hand) -->
                <line x1="100" y1="100" x2="100" y2="34" stroke-width="4.5" stroke-linecap="round" 
                      class="analog-hand-min" id="hand-min" :transform="`rotate(${minuteDeg}, 100, 100)`" />

                <!-- عقرب الثواني الأحمر (Second Hand with Counterweight) -->
                <line x1="100" y1="116" x2="100" y2="24" stroke="#ef4444" stroke-width="2.2" stroke-linecap="round" 
                      id="hand-sec" :transform="`rotate(${secondDeg}, 100, 100)`" />

                <!-- نقطة الارتكاز المركزية الفاخرة (Crimson Hub & White Dot) -->
                <circle cx="100" cy="100" r="6.5" fill="#ef4444" />
                <circle cx="100" cy="100" r="2.2" fill="#ffffff" />
            </svg>
        </div>
    </div>

    <style>
        /* 1. حاوية الكبسولة الرقمية */
        .digital-clock-card {
            background: linear-gradient(135deg, #f0f7ff, #f8fafc, #e0f2fe);
            border-color: #bfdbfe;
            transition: all 0.3s ease;
        }

        .dark .digital-clock-card {
            background: linear-gradient(135deg, #0f172a, #1e293b) !important;
            border-color: #334155 !important;
        }

        /* 2. كبسولات أرقام الوقت (الساعات والدقائق) */
        .digital-clock-pill {
            background-color: #ffffff;
            color: #0f172a;
            border: 1.5px solid #cbd5e1;
            transition: all 0.2s ease;
        }

        .dark .digital-clock-pill {
            background-color: #0b1120 !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        /* 3. كبسولة AM / PM */
        .digital-clock-ampm {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1.5px solid #bfdbfe;
        }

        .dark .digital-clock-ampm {
            background-color: rgba(30, 58, 138, 0.5) !important;
            color: #93c5fd !important;
            border-color: rgba(59, 130, 246, 0.4) !important;
        }

        /* 4. شريط التاريخ */
        .digital-clock-date {
            background-color: #ffffff;
            color: #334155;
            border: 1px solid #bfdbfe;
        }

        .dark .digital-clock-date {
            background-color: #0b1120 !important;
            color: #cbd5e1 !important;
            border-color: #334155 !important;
        }

        /* قاعدة الإطار الدائري الخارجي */
        .analog-dial-base {
            fill: #ffffff;
            stroke: #cbd5e1;
            transition: fill 0.3s ease, stroke 0.3s ease;
        }

        .dark .analog-dial-base {
            fill: #0f172a !important;
            stroke: #334155 !important;
        }

        /* الحلقة الداخلية للقرص */
        .analog-dial-inner {
            fill: none;
            stroke: #f1f5f9;
        }

        .dark .analog-dial-inner {
            stroke: #1e293b !important;
        }

        /* أرقام الساعة الـ 12 */
        .analog-dial-number {
            fill: #1e293b;
            font-family: 'Cairo', 'Tajawal', sans-serif;
            user-select: none;
        }

        .dark .analog-dial-number {
            fill: #f1f5f9 !important;
        }

        /* تدريجات الساعات الرئيسية */
        .analog-tick-hour {
            stroke: #475569;
        }

        .dark .analog-tick-hour {
            stroke: #94a3b8 !important;
        }

        /* تدريجات الدقائق الفرعية */
        .analog-tick-min {
            stroke: #94a3b8;
        }

        .dark .analog-tick-min {
            stroke: #475569 !important;
        }

        /* عقرب الساعات */
        .analog-hand-hour {
            stroke: #2e384d;
            transition: transform 0.2s cubic-bezier(0.4, 2.08, 0.55, 0.44);
        }

        .dark .analog-hand-hour {
            stroke: #f1f5f9 !important;
        }

        /* عقرب الدقائق */
        .analog-hand-min {
            stroke: #475569;
            transition: transform 0.2s cubic-bezier(0.4, 2.08, 0.55, 0.44);
        }

        .dark .analog-hand-min {
            stroke: #60a5fa !important;
        }
    </style>

</div>
