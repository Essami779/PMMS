// Mobile App Simulator Logic - Fully Activated & Interactive with Health Sync

document.addEventListener('DOMContentLoaded', () => {
  // Mobile Nav Tab Switching
  const navItems = document.querySelectorAll('.phone-nav-item');
  const screens = document.querySelectorAll('.tab-screen');
  const controlBadges = document.querySelectorAll('.feature-badge-item');

  function switchTab(tabId) {
    navItems.forEach(item => item.classList.remove('active'));
    screens.forEach(screen => screen.classList.remove('active'));
    controlBadges.forEach(badge => badge.classList.remove('active'));

    const targetNav = document.querySelector(`.phone-nav-item[data-tab="${tabId}"]`);
    const targetScreen = document.getElementById(tabId);
    const targetBadge = document.querySelector(`.feature-badge-item[data-tab="${tabId}"]`);

    if (targetNav) targetNav.classList.add('active');
    if (targetScreen) targetScreen.classList.add('active');
    if (targetBadge) targetBadge.classList.add('active');
  }

  navItems.forEach(item => {
    item.addEventListener('click', () => {
      switchTab(item.getAttribute('data-tab'));
    });
  });

  controlBadges.forEach(badge => {
    badge.addEventListener('click', () => {
      switchTab(badge.getAttribute('data-tab'));
    });
  });

  // -- 1. CLIENT PORTAL LOGIC (Milestones & Invoices) --
  const milestoneDots = document.querySelectorAll('.timeline-item');
  const progressText = document.getElementById('progress-percentage');
  const progressCircle = document.getElementById('progress-svg-circle');
  
  if (milestoneDots && progressCircle) {
    milestoneDots.forEach(dot => {
      dot.querySelector('.timeline-dot').addEventListener('click', () => {
        dot.classList.toggle('completed');
        updateClientProgress();
      });
    });
  }

  function updateClientProgress() {
    const totalMilestones = milestoneDots.length;
    const completedMilestones = document.querySelectorAll('.timeline-item.completed').length;
    const percentage = Math.round((completedMilestones / totalMilestones) * 100);
    
    if (progressText) progressText.innerText = `${percentage}%`;
    
    const circumference = 163.36;
    const offset = circumference - (percentage / 100) * circumference;
    if (progressCircle) {
      progressCircle.style.strokeDashoffset = offset;
    }
  }

  // Invoice paying with inline checkout modal
  const payButtons = document.querySelectorAll('.invoice-btn');
  const paymentModal = document.getElementById('mobile-payment-modal');
  const confirmPaymentBtn = document.getElementById('confirm-mobile-payment');
  const cancelPaymentBtn = document.getElementById('cancel-mobile-payment');
  const paymentAmountEl = document.getElementById('payment-amount');
  let activePayButton = null;

  payButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      if (!btn.classList.contains('paid')) {
        activePayButton = btn;
        const price = btn.closest('.invoice-item').querySelector('.invoice-price').innerText;
        if (paymentAmountEl) paymentAmountEl.innerText = price;
        if (paymentModal) paymentModal.classList.add('active');
      }
    });
  });

  if (confirmPaymentBtn && paymentModal) {
    confirmPaymentBtn.addEventListener('click', () => {
      confirmPaymentBtn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:12px; height:12px;"></i> معالجة...';
      lucide.createIcons();
      confirmPaymentBtn.disabled = true;

      setTimeout(() => {
        if (activePayButton) {
          activePayButton.className = 'invoice-btn paid';
          activePayButton.innerText = 'تم الدفع';
        }
        paymentModal.classList.remove('active');
        confirmPaymentBtn.innerHTML = 'تأكيد الدفع والسداد';
        confirmPaymentBtn.disabled = false;
        showToast('تم دفع الفاتورة بنجاح بقيمة ' + paymentAmountEl.innerText);
      }, 1500);
    });
  }

  if (cancelPaymentBtn && paymentModal) {
    cancelPaymentBtn.addEventListener('click', () => {
      paymentModal.classList.remove('active');
    });
  }

  // -- 2. EMPLOYEE PORTAL LOGIC (Skills, Hardware requests, Fitbit Sync) --
  const skillButtons = document.querySelectorAll('.skill-start-btn');
  const expPointsElement = document.getElementById('employee-xp');

  skillButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      if (!btn.classList.contains('completed')) {
        btn.innerHTML = '<i data-lucide="loader" class="spin" style="width:12px;height:12px;"></i> 0%';
        btn.disabled = true;
        lucide.createIcons();
        
        let percent = 0;
        const interval = setInterval(() => {
          percent += 25;
          btn.innerHTML = `<i data-lucide="loader" class="spin" style="width:12px;height:12px;"></i> ${percent}%`;
          lucide.createIcons();
          if (percent >= 100) {
            clearInterval(interval);
            btn.className = 'skill-start-btn completed';
            btn.innerText = 'مكتمل';
            btn.disabled = false;
            
            if (expPointsElement) {
              const currentXp = parseInt(expPointsElement.innerText);
              expPointsElement.innerText = `${currentXp + 20} XP`;
            }
            showToast('رائع! حصلت على +20 نقطة خبرة لتطوير مهاراتك.');
          }
        }, 250);
      }
    });
  });

  // Hardware Request Dialog
  const requestAssetBtn = document.getElementById('request-asset-btn');
  const assetModal = document.getElementById('mobile-asset-modal');
  const submitAssetBtn = document.getElementById('submit-asset-request');
  const cancelAssetBtn = document.getElementById('cancel-asset-request');
  const assetSelect = document.getElementById('asset-select');

  if (requestAssetBtn && assetModal) {
    requestAssetBtn.addEventListener('click', () => {
      assetModal.classList.add('active');
    });
  }

  if (submitAssetBtn && assetModal) {
    submitAssetBtn.addEventListener('click', () => {
      const selectedDevice = assetSelect.options[assetSelect.selectedIndex].text;
      submitAssetBtn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:12px; height:12px;"></i> إرسال...';
      lucide.createIcons();
      submitAssetBtn.disabled = true;

      setTimeout(() => {
        assetModal.classList.remove('active');
        submitAssetBtn.innerHTML = 'إرسال طلب العُهدة';
        submitAssetBtn.disabled = false;
        showToast(`تم إرسال طلب عهدة (${selectedDevice}) للمشرف بنجاح!`);
        addSupervisorPendingRequest(selectedDevice);
      }, 1200);
    });
  }

  if (cancelAssetBtn && assetModal) {
    cancelAssetBtn.addEventListener('click', () => {
      assetModal.classList.remove('active');
    });
  }

  // Interactive Health Sync widget (New Feature!)
  const syncHealthBtn = document.getElementById('sync-health-btn');
  const heartIcon = document.getElementById('health-heart-icon');
  const stepsCountText = document.getElementById('health-steps-count');
  const heartRateText = document.getElementById('health-heart-rate');
  const bloodOxygenText = document.getElementById('health-blood-oxygen');

  if (syncHealthBtn) {
    syncHealthBtn.addEventListener('click', () => {
      syncHealthBtn.disabled = true;
      syncHealthBtn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:12px; height:12px;"></i> جاري المزامنة...';
      lucide.createIcons();
      
      if (heartIcon) heartIcon.classList.add('pulse');

      let currentSteps = 3120;
      const targetSteps = 6450;
      const stepInterval = setInterval(() => {
        currentSteps += 166;
        if (stepsCountText) stepsCountText.innerText = currentSteps.toLocaleString('en-US');
        if (currentSteps >= targetSteps) {
          clearInterval(stepInterval);
          if (stepsCountText) stepsCountText.innerText = targetSteps.toLocaleString('en-US');
          if (heartRateText) heartRateText.innerText = '74 bpm';
          if (bloodOxygenText) bloodOxygenText.innerText = '98%';
          
          if (heartIcon) heartIcon.classList.remove('pulse');
          syncHealthBtn.disabled = false;
          syncHealthBtn.innerHTML = '<i data-lucide="refresh-cw" style="width:12px; height:12px;"></i> مزامنة النشاط البدني';
          lucide.createIcons();
          showToast('تمت المزامنة بنجاح مع Apple Health و Fitbit!');
        }
      }, 40);
    });
  }

  // -- 3. SUPERVISOR VIEW LOGIC (Stopwatch, logs & approvals) --
  const timerElement = document.getElementById('stopwatch-timer');
  const checkInOutBtn = document.getElementById('supervisor-check-btn');
  const checkStatusText = document.getElementById('supervisor-status-text');
  const activityList = document.querySelector('.activity-log-list');

  let seconds = 24135; // 06:42:15
  let timerInterval = null;
  let isTracking = true;

  function startStopwatch() {
    timerInterval = setInterval(() => {
      seconds++;
      const hrs = Math.floor(seconds / 3600).toString().padStart(2, '0');
      const mins = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
      const secs = (seconds % 60).toString().padStart(2, '0');
      if (timerElement) {
        timerElement.innerText = `${hrs}:${mins}:${secs}`;
      }
    }, 1000);
  }

  startStopwatch();

  if (checkInOutBtn) {
    checkInOutBtn.addEventListener('click', () => {
      isTracking = !isTracking;
      const now = new Date();
      const timeString = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

      if (isTracking) {
        startStopwatch();
        checkInOutBtn.innerText = 'تسجيل خروج';
        checkInOutBtn.style.background = 'var(--danger)';
        if (checkStatusText) {
          checkStatusText.innerText = 'نشط حالياً ويتم تسجيل الوقت';
          checkStatusText.style.color = 'var(--success)';
        }
        addLog('تم تسجيل الدخول واستئناف العمل', 'checkin', timeString);
        showToast('تم استئناف تتبع ساعات العمل بنجاح.');
      } else {
        clearInterval(timerInterval);
        checkInOutBtn.innerText = 'تسجيل دخول';
        checkInOutBtn.style.background = 'var(--success)';
        if (checkStatusText) {
          checkStatusText.innerText = 'متوقف مؤقتاً';
          checkStatusText.style.color = 'var(--text-muted)';
        }
        addLog('تم تسجيل الخروج وإيقاف تتبع الوقت', 'checkout', timeString);
        showToast('تم إيقاف تتبع ساعات العمل مؤقتاً.');
      }
    });
  }

  // Interactive Supervisor request approvals
  const approveReqBtn = document.getElementById('supervisor-approve-req-btn');
  const requestContainer = document.getElementById('supervisor-pending-request-box');

  if (approveReqBtn && requestContainer) {
    approveReqBtn.addEventListener('click', () => {
      approveReqBtn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:12px; height:12px;"></i> معالجة...';
      lucide.createIcons();
      approveReqBtn.disabled = true;

      setTimeout(() => {
        requestContainer.style.animation = 'fadeOut 0.4s ease';
        setTimeout(() => {
          requestContainer.remove();
          showToast('تم الموافقة على طلب الإجازة المقدم من أحمد!');
        }, 400);
      }, 1000);
    });
  }

  // Helper functions
  function addLog(text, type, time) {
    if (activityList) {
      const log = document.createElement('div');
      log.className = `activity-log-item ${type}`;
      log.innerHTML = `
        <div>${text}</div>
        <div class="activity-log-time">${time}</div>
      `;
      activityList.prepend(log);
      while (activityList.children.length > 5) {
        activityList.removeChild(activityList.lastChild);
      }
    }
  }

  function showToast(message) {
    const toast = document.createElement('div');
    toast.style.position = 'absolute';
    toast.style.bottom = '90px';
    toast.style.left = '20px';
    toast.style.right = '20px';
    toast.style.background = 'rgba(15, 23, 42, 0.95)';
    toast.style.border = '1px solid var(--primary)';
    toast.style.padding = '12px 16px';
    toast.style.borderRadius = '12px';
    toast.style.fontSize = '0.8rem';
    toast.style.color = 'white';
    toast.style.textAlign = 'center';
    toast.style.boxShadow = '0 10px 25px rgba(0,0,0,0.5)';
    toast.style.zIndex = '999';
    toast.style.animation = 'fadeIn 0.3s ease';
    toast.innerText = message;
    
    const body = document.querySelector('.phone-screen');
    if (body) {
      body.appendChild(toast);
      setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
      }, 2500);
    }
  }

  function addSupervisorPendingRequest(deviceName) {
    const now = new Date();
    const timeString = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });
    addLog(`طلب موظف عُهدة جديدة: ${deviceName}`, 'commit', timeString);
  }
});
