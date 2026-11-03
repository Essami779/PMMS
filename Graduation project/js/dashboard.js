// Supervisor & Admin Dashboard Mockup Logic - Fully Activated & Interactive with Heatmap Calendar

document.addEventListener('DOMContentLoaded', () => {
  // Real-time server load indicator jitter
  const serverLoadEl = document.getElementById('server-load-text');
  if (serverLoadEl) {
    setInterval(() => {
      const current = parseFloat(serverLoadEl.innerText);
      const diff = (Math.random() * 4 - 2).toFixed(1);
      let next = (current + parseFloat(diff)).toFixed(1);
      if (next < 10) next = 10.5;
      if (next > 90) next = 89.2;
      serverLoadEl.innerText = `${next}%`;
    }, 4000);
  }

  // -- 1. ACTIVITY TABLE FILTERING & SEARCH --
  const searchInput = document.getElementById('employee-search');
  const roleFilter = document.getElementById('role-filter');
  const tableRows = document.querySelectorAll('.activity-table tbody tr');

  function filterTable() {
    const query = searchInput.value.toLowerCase();
    const selectedRole = roleFilter.value;

    tableRows.forEach(row => {
      const name = row.getAttribute('data-name').toLowerCase();
      const role = row.getAttribute('data-role');
      const matchesSearch = name.includes(query);
      const matchesRole = selectedRole === 'all' || role === selectedRole;
      row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
    });
  }

  if (searchInput && roleFilter) {
    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
  }

  // -- 2. EMPLOYEE DETAILS MODAL WITH CONTROL ACTIONS --
  const modal = document.getElementById('employee-modal');
  const closeModalBtn = document.getElementById('close-modal-btn');
  const modalTitle = document.getElementById('modal-employee-name');
  const modalRole = document.getElementById('modal-employee-role');
  const modalTimeline = document.getElementById('modal-timeline');
  const sendWarningBtn = document.getElementById('modal-send-warning-btn');
  const exportLogBtn = document.getElementById('modal-export-log-btn');

  const employeeDetails = {
    'أحمد العتيبي': {
      role: 'مطور فلاتر (Flutter Developer)',
      actions: [
        { time: '10:45 AM', text: 'تم رفع كود تحديث واجهة الفواتير لـ GitHub' },
        { time: '09:30 AM', text: 'مراجعة والموافقة على Pull Request #22' },
        { time: '09:00 AM', text: 'تسجيل دخول إلى تطبيق الموبايل وبدء العمل' }
      ]
    },
    'سارة الأحمد': {
      role: 'مهندسة خلفية (Laravel Backend)',
      actions: [
        { time: '11:15 AM', text: 'دمج فرع حماية الموارد auth-security في Laravel' },
        { time: '10:00 AM', text: 'حل مشكلة إرسال الفواتير الإلكترونية المكررة' },
        { time: '08:45 AM', text: 'تسجيل دخول وبدء الجلسة اليومية' }
      ]
    },
    'فيصل خالد': {
      role: 'مهندس ديف اوبس (DevOps Engineer)',
      actions: [
        { time: '12:00 PM', text: 'تشغيل أوتوماتيكي لبيئة الإنتاج والتحقق من الاستقرار' },
        { time: '10:30 AM', text: 'تعديل ملف yaml الخاص بـ GitHub Actions' },
        { time: '09:15 AM', text: 'تسجيل دخول ومراجعة أداء الخوادم' }
      ]
    },
    'خالد العمران': {
      role: 'مصمم واجهات (UI/UX Designer)',
      actions: [
        { time: '02:30 PM', text: 'تصدير تصاميم لوحة التحكم السمة الداكنة إلى Figma' },
        { time: '11:00 AM', text: 'تعديل لوحة الألوان للمنصة وإضافة ميزات الموبايل' },
        { time: '09:30 AM', text: 'تسجيل دخول واجتماع تخطيطي مع العملاء' }
      ]
    }
  };

  let activeEmployee = '';

  tableRows.forEach(row => {
    row.addEventListener('click', () => {
      const name = row.getAttribute('data-name');
      const data = employeeDetails[name];

      if (data && modal) {
        activeEmployee = name;
        modalTitle.innerText = `سجل نشاط اليوم: ${name}`;
        modalRole.innerText = data.role;
        
        if (sendWarningBtn) {
          sendWarningBtn.className = 'btn btn-secondary';
          sendWarningBtn.style.background = '';
          sendWarningBtn.innerHTML = '<i data-lucide="alert-octagon" style="width:14px; height:14px;"></i> إرسال تنبيه للموظف';
        }

        modalTimeline.innerHTML = '';
        data.actions.forEach(act => {
          const node = document.createElement('div');
          node.className = 'action-node';
          node.innerHTML = `
            <div><strong>${act.text}</strong></div>
            <span>الساعة: ${act.time}</span>
          `;
          modalTimeline.appendChild(node);
        });

        modal.classList.add('active');
        lucide.createIcons();
      }
    });
  });

  if (sendWarningBtn) {
    sendWarningBtn.addEventListener('click', () => {
      sendWarningBtn.className = 'btn btn-primary';
      sendWarningBtn.style.background = 'var(--danger)';
      sendWarningBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:14px; height:14px;"></i> جاري الإرسال...';
      lucide.createIcons();

      setTimeout(() => {
        sendWarningBtn.innerHTML = '<i data-lucide="check" style="width:14px; height:14px;"></i> تم التنبيه بنجاح!';
        lucide.createIcons();
        showToastNotification(`تم إرسال تنبيه إداري عاجل إلى الموظف ${activeEmployee}`);
      }, 1000);
    });
  }

  if (exportLogBtn) {
    exportLogBtn.addEventListener('click', () => {
      exportLogBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:14px; height:14px;"></i> جاري التصدير...';
      lucide.createIcons();

      setTimeout(() => {
        exportLogBtn.innerHTML = '<i data-lucide="download" style="width:14px; height:14px;"></i> تصدير السجل اليومي CSV';
        lucide.createIcons();
        showToastNotification(`تم تصدير سجل نشاط ${activeEmployee} بنجاح كملف CSV!`);
      }, 1200);
    });
  }

  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('active');
    });
  }

  // -- 3. DEVOPS CI/CD PIPELINE BUILD TRIGGERS --
  const triggerProdBtn = document.getElementById('trigger-prod-btn');
  const triggerStagingBtn = document.getElementById('trigger-staging-btn');
  const prodPipeline = document.getElementById('prod-pipeline');
  const stagingPipeline = document.getElementById('staging-pipeline');

  function animatePipeline(pipelineEl, buttonEl, successMessage) {
    buttonEl.disabled = true;
    buttonEl.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:14px; height:14px;"></i> جاري البناء...';
    lucide.createIcons();

    const steps = pipelineEl.querySelectorAll('.step-node');
    const badge = pipelineEl.querySelector('.pipeline-status-badge');
    
    badge.className = 'pipeline-status-badge running';
    badge.innerText = 'جاري التشغيل';

    steps.forEach(step => {
      step.className = 'step-node pending';
      step.querySelector('.step-indicator').innerHTML = '';
    });

    runStep(0);

    function runStep(index) {
      if (index >= steps.length) {
        badge.className = 'pipeline-status-badge success';
        badge.innerText = 'مكتمل بنجاح';
        
        buttonEl.disabled = false;
        buttonEl.innerHTML = '<i data-lucide="play" style="width:14px; height:14px;"></i> إعادة تشغيل البناء';
        lucide.createIcons();
        
        showToastNotification(successMessage);
        return;
      }

      const currentStep = steps[index];
      currentStep.className = 'step-node active';
      currentStep.querySelector('.step-indicator').innerHTML = '<i data-lucide="loader" class="spin" style="width:12px; height:12px;"></i>';
      lucide.createIcons();

      setTimeout(() => {
        currentStep.className = 'step-node completed';
        currentStep.querySelector('.step-indicator').innerHTML = '<i data-lucide="check" style="width:12px; height:12px;"></i>';
        lucide.createIcons();
        runStep(index + 1);
      }, 1200);
    }
  }

  if (triggerProdBtn && prodPipeline) {
    triggerProdBtn.addEventListener('click', () => {
      animatePipeline(prodPipeline, triggerProdBtn, 'اكتمل بناء ونشر بيئة الإنتاج بنجاح (Production Env Updated)!');
    });
  }

  if (triggerStagingBtn && stagingPipeline) {
    triggerStagingBtn.addEventListener('click', () => {
      animatePipeline(stagingPipeline, triggerStagingBtn, 'اكتمل بناء ونشر بيئة التجريب والعملاء (Staging Env Updated)!');
    });
  }

  // -- 4. FINANCIAL ANALYTICS - DYNAMIC PROJECT SELECT --
  const financeSelect = document.getElementById('finance-project-select');
  const barBudget1 = document.getElementById('budget-bar-1');
  const barBurn1 = document.getElementById('burn-bar-1');
  const barBudget2 = document.getElementById('budget-bar-2');
  const barBurn2 = document.getElementById('burn-bar-2');
  const barBudget3 = document.getElementById('budget-bar-3');
  const barBurn3 = document.getElementById('burn-bar-3');

  if (financeSelect) {
    financeSelect.addEventListener('change', () => {
      const proj = financeSelect.value;
      if (proj === 'iyad') {
        animateRectHeight(barBudget1, 30, 100);
        animateRectHeight(barBurn1, 45, 85);
        animateRectHeight(barBudget2, 50, 80);
        animateRectHeight(barBurn2, 70, 60);
        animateRectHeight(barBudget3, 75, 55);
        animateRectHeight(barBurn3, 80, 50);
      } else {
        animateRectHeight(barBudget1, 20, 110);
        animateRectHeight(barBurn1, 60, 70);
        animateRectHeight(barBudget2, 40, 90);
        animateRectHeight(barBurn2, 50, 80);
        animateRectHeight(barBudget3, 60, 70);
        animateRectHeight(barBurn3, 85, 45);
      }
    });
  }

  function animateRectHeight(rect, targetY, targetHeight) {
    if (rect) {
      rect.setAttribute('y', targetY);
      rect.setAttribute('height', targetHeight);
    }
  }

  // -- 5. RESOURCE MANAGEMENT - AI WORKLOAD BALANCER --
  const balanceWorkloadBtn = document.getElementById('balance-workload-btn');
  const warningContainer = document.getElementById('workload-warning-box');
  
  const sarahCapacityFill = document.getElementById('sarah-capacity-fill');
  const sarahCapacityLabel = document.getElementById('sarah-capacity-label');
  
  const faisalCapacityFill = document.getElementById('faisal-capacity-fill');
  const faisalCapacityLabel = document.getElementById('faisal-capacity-label');

  if (balanceWorkloadBtn && warningContainer) {
    balanceWorkloadBtn.addEventListener('click', () => {
      balanceWorkloadBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:14px; height:14px;"></i> جاري موازنة المهام...';
      lucide.createIcons();
      balanceWorkloadBtn.disabled = true;

      setTimeout(() => {
        if (sarahCapacityFill && sarahCapacityLabel) {
          sarahCapacityFill.style.width = '70%';
          sarahCapacityFill.style.background = 'var(--primary)';
          sarahCapacityLabel.innerText = '70% (مستقر)';
          sarahCapacityLabel.style.color = 'var(--success)';
        }

        if (faisalCapacityFill && faisalCapacityLabel) {
          faisalCapacityFill.style.width = '85%';
          faisalCapacityFill.style.background = 'var(--warning)';
          faisalCapacityLabel.innerText = '85% (نشط)';
          faisalCapacityLabel.style.color = 'var(--warning)';
        }

        warningContainer.style.background = 'rgba(16,185,129,0.06)';
        warningContainer.style.borderColor = 'rgba(16,185,129,0.2)';
        warningContainer.innerHTML = `
          <h5 style="color:var(--success); font-size:0.85rem; font-weight:700; display:flex; align-items:center; gap:6px;">
            <i data-lucide="check-circle" style="width:16px; height:16px;"></i>
            تمت موازنة المهام بالذكاء الاصطناعي
          </h5>
          <p style="font-size:0.75rem; color:var(--text-secondary); margin-top:4px; line-height:1.4">
            تم إعادة توزيع مهام مراجعة الأكواد المعلقة من سارة الأحمد إلى فيصل خالد بنجاح لضمان تسليم المشاريع دون تأخير.
          </p>
        `;
        lucide.createIcons();
        showToastNotification('تمت إعادة جدولة وتوزيع المهام تلقائياً بالذكاء الاصطناعي بنجاح!');
      }, 1500);
    });
  }

  // -- 6. GITHUB CONTRIBUTION HEATMAP GRID GENERATOR (NEW FEATURE!) --
  const heatmapGrid = document.getElementById('github-contribution-grid');
  const triggerCommitBtn = document.getElementById('trigger-git-commit-btn');
  const totalCommitsText = document.getElementById('total-commits-count');

  let totalCommits = 1435;

  if (heatmapGrid) {
    // Generate 52 weeks of columns
    for (let w = 0; w < 52; w++) {
      const col = document.createElement('div');
      col.className = 'heatmap-col';
      
      // Generate 7 days in each column
      for (let d = 0; d < 7; d++) {
        const sq = document.createElement('div');
        sq.className = 'heatmap-square';
        
        // Randomize levels (0 to 4) for high-fidelity look
        // We make level-0 and level-1 most common for realistic contribution map
        const rand = Math.random();
        let level = 0;
        if (rand > 0.85) level = 4;
        else if (rand > 0.7) level = 3;
        else if (rand > 0.45) level = 2;
        else if (rand > 0.15) level = 1;
        
        sq.classList.add(`bg-level-${level}`);
        
        // Mock tooltip count
        const commitCount = level === 0 ? 0 : Math.round(level * (Math.random() * 3 + 1));
        sq.title = `${commitCount} commits on Day ${d + 1}, Week ${w + 1}`;
        
        // Mark the last square of the last week as Today
        if (w === 51 && d === 6) {
          sq.id = 'today-heatmap-square';
          sq.title = 'اليوم: 0 commits';
          sq.className = 'heatmap-square bg-level-0'; // start empty today
        }

        col.appendChild(sq);
      }
      heatmapGrid.appendChild(col);
    }
  }

  if (triggerCommitBtn) {
    triggerCommitBtn.addEventListener('click', () => {
      triggerCommitBtn.disabled = true;
      triggerCommitBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:14px; height:14px;"></i> جاري الدفع...';
      lucide.createIcons();

      setTimeout(() => {
        const todaySq = document.getElementById('today-heatmap-square');
        if (todaySq) {
          todaySq.className = 'heatmap-square bg-level-4';
          todaySq.title = 'اليوم: 5 commits (شعبة رئيسية)';
          
          // scale pop today's square
          todaySq.style.transform = 'scale(1.5)';
          todaySq.style.boxShadow = '0 0 10px #39d353';
          setTimeout(() => {
            todaySq.style.transform = '';
            todaySq.style.boxShadow = '';
          }, 800);
        }

        // Increment total count
        totalCommits++;
        if (totalCommitsText) totalCommitsText.innerText = totalCommits;

        triggerCommitBtn.disabled = false;
        triggerCommitBtn.innerHTML = '<i data-lucide="git-pull-request" style="width:14px; height:14px;"></i> رفع كود تجريبي ودفع مساهمة';
        lucide.createIcons();
        showToastNotification('تم دفع الـ commit بنجاح للمستودع وتحديث خريطة مساهمات GitHub للوكالة!');
      }, 1200);
    });
  }

  // Toast Notification Helper
  function showToastNotification(message) {
    const toast = document.createElement('div');
    toast.style.position = 'fixed';
    toast.style.bottom = '30px';
    toast.style.left = '30px';
    toast.style.background = 'rgba(15,23,42,0.95)';
    toast.style.border = '1px solid var(--primary)';
    toast.style.padding = '14px 20px';
    toast.style.borderRadius = '12px';
    toast.style.fontSize = '0.85rem';
    toast.style.color = 'white';
    toast.style.boxShadow = '0 10px 30px rgba(0,0,0,0.5)';
    toast.style.zIndex = '10000';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '10px';
    toast.style.animation = 'fadeIn 0.3s ease';
    toast.innerHTML = `
      <i data-lucide="info" style="color:var(--accent); width:18px; height:18px;"></i>
      <span>${message}</span>
    `;
    document.body.appendChild(toast);
    lucide.createIcons();
    setTimeout(() => {
      toast.style.animation = 'fadeOut 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }
});
