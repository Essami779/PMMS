// Desktop Web Application Mockup Logic - Fully Activated & Interactive with Changelog Generator

document.addEventListener('DOMContentLoaded', () => {
  // Sidebar Navigation Switching
  const menuItems = document.querySelectorAll('.menu-item');
  const pageViews = document.querySelectorAll('.page-view');

  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      const pageId = item.getAttribute('data-page');
      menuItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      pageViews.forEach(view => view.classList.remove('active'));
      const activeView = document.getElementById(pageId);
      if (activeView) activeView.classList.add('active');
    });
  });

  // -- 1. CLIENT DASHBOARD LOGIC --
  // Roadmap Collapsible Nodes
  const nodes = document.querySelectorAll('.roadmap-node');
  nodes.forEach(node => {
    node.querySelector('.roadmap-node-header').addEventListener('click', () => {
      node.classList.toggle('open');
    });
  });

  // File Downloads Simulation
  const fileCards = document.querySelectorAll('.file-card');
  fileCards.forEach(card => {
    card.addEventListener('click', () => {
      const title = card.querySelector('h5').innerText;
      const subtitle = card.querySelector('p');
      const originalText = subtitle.innerText;
      
      card.style.pointerEvents = 'none';
      subtitle.innerHTML = '<i data-lucide="loader" class="spin" style="width:12px; height:12px;"></i> جاري التحميل...';
      lucide.createIcons();
      
      setTimeout(() => {
        subtitle.innerText = 'تم التحميل!';
        subtitle.style.color = 'var(--success)';
        showCustomAlert(`تم تحميل الملف: ${title} بنجاح من سيرفرات الوكالة!`);
        setTimeout(() => {
          subtitle.innerText = originalText;
          subtitle.style.color = '';
          card.style.pointerEvents = '';
        }, 2000);
      }, 1500);
    });
  });

  // Invoice Payment Modal Flow
  const payInvoiceBtn = document.getElementById('web-pay-invoice-btn');
  const paymentModal = document.getElementById('web-payment-modal');
  const closePaymentModalBtn = document.getElementById('close-web-payment-btn');
  const submitPaymentBtn = document.getElementById('submit-web-payment');
  const invoiceBox = document.getElementById('web-pending-invoice-box');

  if (payInvoiceBtn && paymentModal) {
    payInvoiceBtn.addEventListener('click', () => {
      paymentModal.classList.add('active');
    });
  }

  if (closePaymentModalBtn && paymentModal) {
    closePaymentModalBtn.addEventListener('click', () => {
      paymentModal.classList.remove('active');
    });
  }

  if (submitPaymentBtn && paymentModal && invoiceBox) {
    submitPaymentBtn.addEventListener('click', () => {
      submitPaymentBtn.disabled = true;
      submitPaymentBtn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width:14px; height:14px;"></i> جاري المعالجة البنكية...';
      lucide.createIcons();

      setTimeout(() => {
        paymentModal.classList.remove('active');
        submitPaymentBtn.disabled = false;
        submitPaymentBtn.innerText = 'سداد الفاتورة إلكترونياً';
        
        invoiceBox.innerHTML = `
          <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
            <strong style="font-size:0.9rem;">الدفعة الثالثة (النشر النهائي)</strong>
            <span style="color:var(--success); font-size:0.8rem; font-weight:700;">مكتملة</span>
          </div>
          <p style="font-size:0.75rem; color:var(--text-muted); margin-bottom:10px;">مدفوعة في: اليوم</p>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-weight:800; font-size:1.1rem; color:var(--text-primary)">3,500$</span>
            <span style="font-size:0.75rem; color:var(--success); font-weight:600; display:flex; align-items:center; gap:4px;">
              <i data-lucide="check" style="width:12px; height:12px;"></i> مدفوعة رقمياً
            </span>
          </div>
        `;
        lucide.createIcons();
        showCustomAlert('شكرًا لك! تم سداد دفعة النشر النهائي (3,500$) بنجاح وتم تعديل الفاتورة رقمياً.');
      }, 1800);
    });
  }

  // -- 2. KANBAN BOARD & DRAG AND DROP --
  const cards = document.querySelectorAll('.kanban-card');
  const containers = document.querySelectorAll('.kanban-cards-container');

  function initDraggableCard(card) {
    card.addEventListener('dragstart', () => {
      card.classList.add('dragging');
    });

    card.addEventListener('dragend', () => {
      card.classList.remove('dragging');
      updateColumnCounts();
    });
  }

  cards.forEach(card => initDraggableCard(card));

  containers.forEach(container => {
    container.addEventListener('dragover', e => {
      e.preventDefault();
      const afterElement = getDragAfterElement(container, e.clientY);
      const dragging = document.querySelector('.dragging');
      if (dragging) {
        if (afterElement == null) {
          container.appendChild(dragging);
        } else {
          container.insertBefore(dragging, afterElement);
        }
      }
    });
  });

  function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.kanban-card:not(.dragging)')];
    return draggableElements.reduce((closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child };
      } else {
        return closest;
      }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
  }

  function updateColumnCounts() {
    containers.forEach(container => {
      const count = container.querySelectorAll('.kanban-card').length;
      const column = container.closest('.kanban-column');
      const countElement = column.querySelector('.kanban-count');
      if (countElement) countElement.innerText = count;
    });
  }

  // Create Task Modal Logic
  const openAddTaskBtn = document.getElementById('open-add-task-btn');
  const addTaskModal = document.getElementById('web-add-task-modal');
  const closeAddTaskBtn = document.getElementById('close-add-task-btn');
  const submitTaskBtn = document.getElementById('submit-new-task');
  const taskTitleInput = document.getElementById('task-title-input');
  const taskAssigneeInput = document.getElementById('task-assignee-input');

  if (openAddTaskBtn && addTaskModal) {
    openAddTaskBtn.addEventListener('click', () => {
      addTaskModal.classList.add('active');
    });
  }

  if (closeAddTaskBtn && addTaskModal) {
    closeAddTaskBtn.addEventListener('click', () => {
      addTaskModal.classList.remove('active');
    });
  }

  if (submitTaskBtn && addTaskModal) {
    submitTaskBtn.addEventListener('click', () => {
      const title = taskTitleInput.value;
      const assignee = taskAssigneeInput.value;

      if (!title.trim()) {
        alert('الرجاء كتابة عنوان للمهمة.');
        return;
      }

      const todoContainer = document.getElementById('kanban-todo-container');
      if (todoContainer) {
        const card = document.createElement('div');
        card.className = 'kanban-card';
        card.draggable = true;
        card.innerHTML = `
          <h6>${title}</h6>
          <div class="kanban-card-meta">
            <span class="github-badge commit">
              <i data-lucide="git-commit" style="width:10px; height:10px;"></i>
              <span>SHA: pending</span>
            </span>
            <span style="font-size:0.65rem;">${assignee}</span>
          </div>
        `;
        initDraggableCard(card);
        todoContainer.appendChild(card);
        lucide.createIcons();
        updateColumnCounts();

        taskTitleInput.value = '';
        addTaskModal.classList.remove('active');
        showCustomAlert(`تم إدراج مهمة جديدة: "${title}" وإسنادها إلى ${assignee}.`);
      }
    });
  }

  // Simulated GitHub Commit Feed
  const commitFeed = document.querySelector('.github-activity-list');
  const authors = ['أحمد العتيبي', 'سارة الأحمد', 'فيصل خالد', 'خالد العمران'];
  const files = ['index.js', 'auth_controller.php', 'api.dart', 'styles.css', 'README.md'];
  const actions = ['تم دفع كود جديد', 'تم تعديل الـ routes', 'تم حل مشكلة الـ Auth', 'تم تحسين سرعة العرض'];

  function addSimulatedCommit() {
    if (!commitFeed) return;
    const randomAuthor = authors[Math.floor(Math.random() * authors.length)];
    const randomFile = files[Math.floor(Math.random() * files.length)];
    const randomAction = actions[Math.floor(Math.random() * actions.length)];
    const hash = Math.random().toString(16).substring(2, 8);
    const now = new Date();
    const timeStr = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });

    const item = document.createElement('div');
    item.className = 'github-activity-item';
    item.style.animation = 'fadeIn 0.5s ease-out';
    item.innerHTML = `
      <div class="github-activity-icon"><i data-lucide="git-commit"></i></div>
      <div class="github-activity-info">
        <p><strong>${randomAuthor}</strong> ${randomAction} في <code>${randomFile}</code></p>
        <span>SHA: ${hash} • اليوم، ${timeStr}</span>
      </div>
    `;
    commitFeed.prepend(item);
    lucide.createIcons();
    while (commitFeed.children.length > 5) {
      commitFeed.removeChild(commitFeed.lastChild);
    }
  }

  setInterval(addSimulatedCommit, 12000);

  // -- 3. FINANCE & SIGNATURE PAD --
  const canvas = document.getElementById('signature-canvas');
  const clearBtn = document.getElementById('clear-sig-btn');
  const signBtn = document.getElementById('sign-contract-btn');
  
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let isDrawing = false;
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;
    ctx.strokeStyle = '#3b82f6';
    ctx.lineWidth = 3;
    ctx.lineCap = 'round';

    function startDraw(e) {
      isDrawing = true;
      draw(e);
    }

    function stopDraw() {
      isDrawing = false;
      ctx.beginPath();
    }

    function draw(e) {
      if (!isDrawing) return;
      const clientX = e.touches ? e.touches[0].clientX : e.clientX;
      const clientY = e.touches ? e.touches[0].clientY : e.clientY;
      const rect = canvas.getBoundingClientRect();
      const x = clientX - rect.left;
      const y = clientY - rect.top;
      ctx.lineTo(x, y);
      ctx.stroke();
      ctx.beginPath();
      ctx.moveTo(x, y);
    }

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mouseup', stopDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('touchstart', (e) => { e.preventDefault(); startDraw(e); });
    canvas.addEventListener('touchend', stopDraw);
    canvas.addEventListener('touchmove', (e) => { e.preventDefault(); draw(e); });

    clearBtn.addEventListener('click', () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    signBtn.addEventListener('click', () => {
      signBtn.disabled = true;
      signBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:14px; height:14px;"></i> جاري إصدار العقد...';
      lucide.createIcons();
      
      setTimeout(() => {
        signBtn.className = 'btn btn-primary';
        signBtn.style.background = 'var(--success)';
        signBtn.style.boxShadow = 'none';
        signBtn.innerText = 'تم التوقيع والمصادقة الرقمية!';
        showCustomAlert('تم اعتماد العقد الإلكتروني وحفظ التوقيع الرقمي بنجاح!');
      }, 1500);
    });
  }

  // Interactive Delay Risk Simulation Slider
  const riskSlider = document.getElementById('risk-simulator-slider');
  const riskPercentText = document.getElementById('risk-percent-text');
  const riskFillBar = document.getElementById('risk-fill-bar');
  const riskLabelText = document.getElementById('risk-label-text');
  const riskCard = document.getElementById('risk-card');

  if (riskSlider && riskPercentText && riskFillBar) {
    riskSlider.addEventListener('input', () => {
      const val = riskSlider.value;
      riskPercentText.innerText = `${val}%`;
      riskFillBar.style.width = `${val}%`;

      if (val < 40) {
        riskLabelText.innerText = 'خطر منخفض للتأخير (مستقر)';
        riskPercentText.style.color = 'var(--success)';
        riskCard.className = 'risk-alert-card glass';
        riskCard.style.borderRightColor = 'var(--success)';
      } else if (val < 75) {
        riskLabelText.innerText = 'خطر متوسط للتأخير (تحذير)';
        riskPercentText.style.color = 'var(--warning)';
        riskCard.className = 'risk-alert-card glass';
        riskCard.style.borderRightColor = 'var(--warning)';
      } else {
        riskLabelText.innerText = 'خطر حرج للتأخير (مخاطرة)';
        riskPercentText.style.color = 'var(--danger)';
        riskCard.className = 'risk-alert-card glass critical';
        riskCard.style.borderRightColor = 'var(--danger)';
      }
    });
  }

  // -- 4. AI CHAT ASSISTANT & CHANGELOG GENERATOR --
  const chatHistory = document.getElementById('chat-history');
  const chatInput = document.getElementById('chat-input');
  const chatSendBtn = document.getElementById('chat-send-btn');
  const suggestionBtns = document.querySelectorAll('.suggestion-prompt-btn');

  function appendMessage(text, isUser) {
    if (!chatHistory) return;
    const message = document.createElement('div');
    message.className = `chat-message ${isUser ? 'user' : 'assistant'}`;
    const avatarIcon = isUser ? 'user' : 'bot';
    message.innerHTML = `
      <div class="chat-message-avatar"><i data-lucide="${avatarIcon}"></i></div>
      <div class="chat-message-bubble">${text}</div>
    `;
    chatHistory.appendChild(message);
    lucide.createIcons();
    chatHistory.scrollTop = chatHistory.scrollHeight;
  }

  function simulateAiTyping(callback) {
    if (!chatHistory) return;
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'chat-message assistant typing';
    typingIndicator.id = 'ai-typing-indicator';
    typingIndicator.innerHTML = `
      <div class="chat-message-avatar"><i data-lucide="bot"></i></div>
      <div class="chat-message-bubble">
        <div class="typing-indicator">
          <div class="typing-dot"></div>
          <div class="typing-dot"></div>
          <div class="typing-dot"></div>
        </div>
      </div>
    `;
    chatHistory.appendChild(typingIndicator);
    lucide.createIcons();
    chatHistory.scrollTop = chatHistory.scrollHeight;

    setTimeout(() => {
      const element = document.getElementById('ai-typing-indicator');
      if (element) element.remove();
      callback();
    }, 1800);
  }

  function handleUserMessage(text) {
    if (!text.trim()) return;
    appendMessage(text, true);
    
    simulateAiTyping(() => {
      let responseText = `أهلاً بك! لقد تلقيت طلبك بخصوص "${text}". كيف يمكنني مساعدتك بشكل تفصيلي في تخطيط أعمال الوكالة؟`;
      
      if (text.includes('خطط') || text.includes('توزيع المهام') || text.includes('workflow')) {
        responseText = `
          <strong>تم توليد خطة توزيع مهام ذكية لمشروع إياد:</strong><br><br>
          * <strong>المرحلة الأولى:</strong> تطوير واجهات Flutter للعميل (أحمد العتيبي - مطور فلاتر) - 5 أيام عمل.<br>
          * <strong>المرحلة الثانية:</strong> مراجعة أمان الـ API في Laravel (سارة الأحمد - مهندسة خلفية) - يومين عمل.<br>
          * <strong>المرحلة الثالثة:</strong> اختبارات الدمج والـ CI/CD (فيصل خالد - مهندس DevOps) - 3 أيام عمل.<br><br>
          <button id="export-tasks-btn" class="btn btn-secondary" style="font-size: 0.75rem; padding: 6px 12px; margin-top: 10px; display: inline-flex; align-items: center; gap: 6px;">
            <i data-lucide="external-link" style="width:12px; height:12px;"></i> تصدير المهام المقترحة إلى لوحة Kanban
          </button>
        `;
      } else if (text.includes('توقع') || text.includes('تأخير') || text.includes('مخاطر')) {
        responseText = `
          بناءً على عمليات النشر الأخيرة ومراجعات الكود المعلقة، فإن <strong>نسبة خطر التأخير المتوقعة هي 75%</strong>.<br>
          السبب الأساسي هو أن <strong>سارة الأحمد</strong> لديها ضغط مهام كبير (95% من سعتها). يُنصح بنقل بعض المهام لفيصل خالد فوراً عبر لوحة الإدارة العامة.
        `;
      } else if (text.includes('تسعير') || text.includes('تكاليف')) {
        responseText = `
          <strong>حساب التكاليف التقريبية لمشروع جديد مماثل لمشروع إياد:</strong><br><br>
          - <strong>بناء الواجهات والـ API (Laravel + Flutter):</strong> 3,200$<br>
          - <strong>ربط GitHub وأتمتة الـ CI/CD:</strong> 800$<br>
          - <strong>دعم الذكاء الاصطناعي والاستشارات:</strong> 1,000$<br>
          <strong>المجموع المقدر للتكلفة:</strong> 5,000$. هامش الربح المقترح: 40%.
        `;
      } else if (text.includes('تحديث') || text.includes('سجل') || text.includes('changelog')) {
        // Collect done tasks names dynamically from Kanban Done column container (New Feature!)
        const doneCards = document.querySelectorAll('#col-done .kanban-card');
        let doneListHtml = '';
        if (doneCards.length > 0) {
          doneCards.forEach(c => {
            const titleText = c.querySelector('h6').innerText;
            doneListHtml += `* **إنجاز:** ${titleText}<br>`;
          });
        } else {
          doneListHtml = '* **إنجاز:** إعداد السيرفر ورفع الكود المبدئي Laravel<br>';
        }

        responseText = `
          <strong>تم توليد سجل التحديثات (Changelog) تلقائياً بالذكاء الاصطناعي الموجه للعميل:</strong><br><br>
          <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-color); padding:12px; border-radius:8px; font-family:monospace; font-size:0.8rem; margin-bottom:12px;">
            <strong>تحديث الإصدار v1.1.0 - مشروع منصة إياد</strong><br><br>
            ${doneListHtml}
            * **تحسين:** معالجة الفواتير وحفظ سجلات التوقيع تشفيرياً
          </div>
          <button id="send-changelog-client-btn" class="btn btn-primary" style="font-size: 0.75rem; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px;">
            <i data-lucide="mail" style="width:12px; height:12px;"></i> إرسال سجل التحديثات لبريد العميل
          </button>
        `;
      }
      
      appendMessage(responseText, false);
      
      const exportBtn = document.getElementById('export-tasks-btn');
      if (exportBtn) {
        exportBtn.addEventListener('click', () => {
          exportTasksToKanban();
          exportBtn.disabled = true;
          exportBtn.innerText = 'تم التصدير للوحة المهام!';
          exportBtn.style.color = 'var(--success)';
        });
      }

      const sendChangelogBtn = document.getElementById('send-changelog-client-btn');
      if (sendChangelogBtn) {
        sendChangelogBtn.addEventListener('click', () => {
          sendChangelogBtn.disabled = true;
          sendChangelogBtn.innerHTML = '<i data-lucide="loader" class="spin" style="width:12px; height:12px;"></i> جاري الإرسال...';
          lucide.createIcons();
          setTimeout(() => {
            sendChangelogBtn.innerHTML = '<i data-lucide="check" style="width:12px; height:12px;"></i> تم الإرسال للعميل!';
            sendChangelogBtn.style.background = 'var(--success)';
            lucide.createIcons();
            showCustomAlert('تم إرسال سجل التحديثات المعتمد (Release Notes) إلى البريد الإلكتروني للعميل بنجاح!');
          }, 1200);
        });
      }
    });
  }

  if (chatSendBtn && chatInput) {
    chatSendBtn.addEventListener('click', () => {
      const text = chatInput.value;
      if (text.trim()) {
        handleUserMessage(text);
        chatInput.value = '';
      }
    });

    chatInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        const text = chatInput.value;
        if (text.trim()) {
          handleUserMessage(text);
          chatInput.value = '';
        }
      }
    });
  }

  suggestionBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const promptText = btn.getAttribute('data-prompt');
      handleUserMessage(promptText);
    });
  });

  function exportTasksToKanban() {
    const todoContainer = document.getElementById('kanban-todo-container');
    if (!todoContainer) return;

    const newTaskData = [
      { title: '[AI] إتمام واجهات فلاتر لمشروع إياد', pr: 'PR #12', type: 'pr' },
      { title: '[AI] فحص ثغرات الـ API في Laravel', pr: 'Auth fix', type: 'commit' }
    ];

    newTaskData.forEach(task => {
      const card = document.createElement('div');
      card.className = 'kanban-card';
      card.draggable = true;
      const badgeClass = task.type === 'pr' ? 'github-badge pr' : 'github-badge commit';
      const badgeIcon = task.type === 'pr' ? 'git-pull-request' : 'git-commit';

      card.innerHTML = `
        <h6>${task.title}</h6>
        <div class="kanban-card-meta">
          <span class="github-badge ${badgeClass}">
            <i data-lucide="${badgeIcon}" style="width:10px; height:10px;"></i>
            <span>${task.pr}</span>
          </span>
          <span style="font-size:0.65rem;">مضاف عبر الذكاء الاصطناعي</span>
        </div>
      `;

      initDraggableCard(card);
      todoContainer.appendChild(card);
    });

    lucide.createIcons();
    updateColumnCounts();
    showCustomAlert('تم إضافة المهام المقترحة بنجاح إلى عمود "قيد التخطيط" في لوحة Kanban!');
  }

  function showCustomAlert(message) {
    const alertBox = document.createElement('div');
    alertBox.style.position = 'fixed';
    alertBox.style.top = '30px';
    alertBox.style.left = '50%';
    alertBox.style.transform = 'translateX(-50%)';
    alertBox.style.background = 'rgba(15, 23, 42, 0.95)';
    alertBox.style.border = '1px solid var(--primary)';
    alertBox.style.padding = '16px 24px';
    alertBox.style.borderRadius = '12px';
    alertBox.style.fontSize = '0.9rem';
    alertBox.style.color = 'white';
    alertBox.style.boxShadow = '0 15px 35px rgba(0,0,0,0.5)';
    alertBox.style.zIndex = '10000';
    alertBox.style.display = 'flex';
    alertBox.style.alignItems = 'center';
    alertBox.style.gap = '10px';
    alertBox.style.animation = 'fadeIn 0.3s ease';
    alertBox.innerHTML = `
      <i data-lucide="check-circle" style="color:var(--success); width:20px; height:20px;"></i>
      <span>${message}</span>
    `;

    document.body.appendChild(alertBox);
    lucide.createIcons();

    setTimeout(() => {
      alertBox.style.animation = 'fadeOut 0.3s ease';
      setTimeout(() => alertBox.remove(), 300);
    }, 4000);
  }
});
