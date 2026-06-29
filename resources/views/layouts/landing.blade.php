<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PMBM MIN 3 Karanganyar')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Roboto:wght@400;500;700&family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">

  @yield('styles')
  <style>
   /* Map Figma-exported font-family aliases (e.g. "PlusJakartaSans-Bold") to the real webfont + weight loaded above */
   @font-face { font-family: "PlusJakartaSans-Regular"; src: local("Plus Jakarta Sans"); font-weight: 400; }
   @font-face { font-family: "PlusJakartaSans-SemiBold"; src: local("Plus Jakarta Sans SemiBold"); font-weight: 600; }
   @font-face { font-family: "PlusJakartaSans-Bold"; src: local("Plus Jakarta Sans Bold"); font-weight: 700; }
   @font-face { font-family: "PlusJakartaSans-ExtraBold"; src: local("Plus Jakarta Sans ExtraBold"); font-weight: 800; }
   @font-face { font-family: "Roboto-Regular"; src: local("Roboto"); font-weight: 400; }
   @font-face { font-family: "Roboto-Medium"; src: local("Roboto Medium"); font-weight: 500; }
   @font-face { font-family: "Roboto-Bold"; src: local("Roboto Bold"); font-weight: 700; }
   @font-face { font-family: "WorkSans-Regular"; src: local("Work Sans"); font-weight: 400; }
   @font-face { font-family: "WorkSans-Bold"; src: local("Work Sans Bold"); font-weight: 700; }
   @font-face { font-family: "HankenGrotesk-Regular"; src: local("Hanken Grotesk"); font-weight: 400; }
   @font-face { font-family: "HankenGrotesk-SemiBold"; src: local("Hanken Grotesk SemiBold"); font-weight: 600; }
   @font-face { font-family: "HankenGrotesk-Bold"; src: local("Hanken Grotesk Bold"); font-weight: 700; }

   body { font-family: "Plus Jakarta Sans", "Work Sans", "Roboto", sans-serif; }
  </style>
  <style>
   a,
   button,
   input,
   select,
   h1,
   h2,
   h3,
   h4,
   h5,
   * {
       box-sizing: border-box;
       margin: 0;
       padding: 0;
       border: none;
       text-decoration: none;
       background: none;
       -webkit-font-smoothing: antialiased;
   }
   
   menu, ol, ul {
       list-style-type: none;
       margin: 0;
       padding: 0;
   }
  </style>
</head>
<body>
  @yield('content')
  @yield('scripts')

  <!-- Chatbox Widget -->
  <div id="pmbmChatWidget" class="pmbm-chat-widget">
    <div class="pmbm-chat-header">
      <div class="pmbm-chat-title-group">
        <div class="pmbm-chat-avatar">🤖</div>
        <div class="pmbm-chat-info">
          <span class="pmbm-chat-name">Asisten PMBM</span>
          <span class="pmbm-chat-status">Online</span>
        </div>
      </div>
      <button class="pmbm-chat-close" onclick="toggleChatbox()">&times;</button>
    </div>
    <div id="pmbmChatMessages" class="pmbm-chat-messages">
      <!-- Chat bubbles will be dynamically appended here -->
    </div>
  </div>

  <!-- Floating Action Button (FAB) -->
  @unless(Request::routeIs('landing.kontak'))
  <button id="pmbmChatFab" class="pmbm-chat-fab" onclick="toggleChatbox()">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="display: block;">
      <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/>
    </svg>
    <span>Tanya Asisten PMBM</span>
  </button>
  @endunless

  <style>
    /* Floating Chatbox Widget */
    .pmbm-chat-widget {
      position: fixed;
      bottom: 95px;
      right: 30px;
      width: 380px;
      max-width: calc(100vw - 40px);
      height: 520px;
      max-height: calc(100vh - 120px);
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(16px) saturate(180%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      border: 1px solid rgba(0, 135, 68, 0.25);
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0, 77, 37, 0.15);
      display: flex;
      flex-direction: column;
      z-index: 9999;
      overflow: hidden;
      opacity: 0;
      transform: translateY(20px) scale(0.95);
      pointer-events: none;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    }
    .pmbm-chat-widget.active {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: auto;
    }
    
    /* Chatbox Header */
    .pmbm-chat-header {
      background: linear-gradient(135deg, #008744 0%, #005b31 100%);
      color: #ffffff;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .pmbm-chat-title-group {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .pmbm-chat-avatar {
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .pmbm-chat-info {
      display: flex;
      flex-direction: column;
    }
    .pmbm-chat-name {
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.3px;
      color: #ffffff;
    }
    .pmbm-chat-status {
      font-size: 11px;
      color: #b2f5b6;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .pmbm-chat-status::before {
      content: '';
      display: inline-block;
      width: 6px;
      height: 6px;
      background-color: #22c55e;
      border-radius: 50%;
    }
    .pmbm-chat-close {
      background: none;
      border: none;
      color: rgba(255, 255, 255, 0.8);
      font-size: 24px;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s;
    }
    .pmbm-chat-close:hover {
      color: #ffffff;
    }

    /* Chatbox Messages */
    .pmbm-chat-messages {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 12px;
      background: rgba(240, 247, 241, 0.4);
    }
    /* Scrollbar */
    .pmbm-chat-messages::-webkit-scrollbar {
      width: 6px;
    }
    .pmbm-chat-messages::-webkit-scrollbar-track {
      background: transparent;
    }
    .pmbm-chat-messages::-webkit-scrollbar-thumb {
      background: rgba(0, 135, 68, 0.2);
      border-radius: 3px;
    }
    .pmbm-chat-messages::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 135, 68, 0.4);
    }

    /* Message Balloons */
    .pmbm-chat-bubble {
      max-width: 85%;
      padding: 12px 16px;
      border-radius: 14px;
      font-size: 13px;
      line-height: 1.5;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
      animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(5px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .pmbm-chat-bubble.assistant {
      background: #ffffff;
      color: #374151;
      align-self: flex-start;
      border-bottom-left-radius: 4px;
      border: 1px solid rgba(0, 135, 68, 0.1);
    }
    .pmbm-chat-bubble.user {
      background: #008744;
      color: #ffffff;
      align-self: flex-end;
      border-bottom-right-radius: 4px;
    }
    .pmbm-chat-bubble.typing {
      background: #ffffff;
      color: #9ca3af;
      align-self: flex-start;
      border-bottom-left-radius: 4px;
      border: 1px solid rgba(0, 135, 68, 0.1);
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 10px 16px;
    }
    .pmbm-chat-dot {
      width: 6px;
      height: 6px;
      background: #008744;
      border-radius: 50%;
      animation: pmbmBounce 1.4s infinite ease-in-out both;
    }
    .pmbm-chat-dot:nth-child(1) { animation-delay: -0.32s; }
    .pmbm-chat-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes pmbmBounce {
      0%, 80%, 100% { transform: scale(0); }
      40% { transform: scale(1.0); }
    }

    /* FAQ Options & Actions */
    .pmbm-chat-options {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-top: 8px;
      width: 100%;
    }
    .pmbm-faq-btn {
      background: #ffffff;
      color: #008744;
      border: 1px solid rgba(0, 135, 68, 0.25);
      padding: 10px 14px;
      border-radius: 10px;
      text-align: left;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.02);
      font-family: inherit;
    }
    .pmbm-faq-btn:hover {
      background: #eef5ed;
      border-color: #008744;
      transform: translateX(4px);
    }
    .pmbm-action-btn {
      background: #008744;
      color: #ffffff !important;
      border: none;
      padding: 10px 14px;
      border-radius: 10px;
      text-align: center;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 135, 68, 0.2);
      text-decoration: none;
      display: inline-block;
      font-family: inherit;
    }
    .pmbm-action-btn:hover {
      background: #005b31;
    }
    .pmbm-action-btn-outline {
      background: #ffffff;
      color: #008744;
      border: 1px dashed #008744;
      padding: 10px 14px;
      border-radius: 10px;
      text-align: center;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
      font-family: inherit;
    }
    .pmbm-action-btn-outline:hover {
      background: #eef5ed;
    }

    /* Floating Action Button (FAB) */
    .pmbm-chat-fab {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #008744;
      color: #ffffff;
      padding: 12px 24px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0px 8px 24px rgba(0, 135, 68, 0.3);
      z-index: 9998;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .pmbm-chat-fab:hover {
      transform: translateY(-3px);
      box-shadow: 0px 12px 28px rgba(0, 135, 68, 0.4);
      background: #005b31;
    }
  </style>

  <script>
    let faqsData = [];
    let chatInitialized = false;

    function toggleChatbox() {
      const chatWidget = document.getElementById('pmbmChatWidget');
      chatWidget.classList.toggle('active');
      if (chatWidget.classList.contains('active') && !chatInitialized) {
        initChat();
      }
    }

    function initChat() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      messagesContainer.innerHTML = '';
      
      // Show typing indicator
      showTypingIndicator();
      
      // Fetch FAQs from API
      fetch('{{ route("landing.faqs.json") }}')
        .then(response => response.json())
        .then(data => {
          faqsData = data;
          removeTypingIndicator();
          
          appendAssistantBubble("Halo! Saya adalah asisten virtual PMBM MIN 3 Karanganyar. Ada yang bisa saya bantu? Silakan pilih salah satu pertanyaan yang sering diajukan di bawah ini:");
          renderFaqOptions();
          chatInitialized = true;
        })
        .catch(error => {
          console.error('Error fetching FAQs:', error);
          removeTypingIndicator();
          appendAssistantBubble("Maaf, terjadi kesalahan saat memuat daftar pertanyaan. Silakan hubungi kami langsung di halaman Kontak.");
          renderContactRedirectButton();
        });
    }

    function appendAssistantBubble(text) {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const bubble = document.createElement('div');
      bubble.className = 'pmbm-chat-bubble assistant';
      bubble.innerHTML = text;
      messagesContainer.appendChild(bubble);
      scrollToBottom();
    }

    function appendUserBubble(text) {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const bubble = document.createElement('div');
      bubble.className = 'pmbm-chat-bubble user';
      bubble.innerText = text;
      messagesContainer.appendChild(bubble);
      scrollToBottom();
    }

    function showTypingIndicator() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const indicator = document.createElement('div');
      indicator.className = 'pmbm-chat-bubble typing';
      indicator.id = 'pmbmTypingIndicator';
      indicator.innerHTML = '<div class="pmbm-chat-dot"></div><div class="pmbm-chat-dot"></div><div class="pmbm-chat-dot"></div>';
      messagesContainer.appendChild(indicator);
      scrollToBottom();
    }

    function removeTypingIndicator() {
      const indicator = document.getElementById('pmbmTypingIndicator');
      if (indicator) {
        indicator.remove();
      }
    }

    function scrollToBottom() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function renderFaqOptions() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const optionsContainer = document.createElement('div');
      optionsContainer.className = 'pmbm-chat-options';
      optionsContainer.id = 'pmbmCurrentOptions';

      faqsData.forEach((faq) => {
        const btn = document.createElement('button');
        btn.className = 'pmbm-faq-btn';
        btn.innerText = faq.question;
        btn.onclick = () => handleFaqSelect(faq);
        optionsContainer.appendChild(btn);
      });

      // Add "Tanya yang lain / Hubungi Sekolah"
      const otherBtn = document.createElement('button');
      otherBtn.className = 'pmbm-action-btn-outline';
      otherBtn.style.textAlign = 'left';
      otherBtn.innerText = '💬 Hubungi Kontak Sekolah';
      otherBtn.onclick = () => handleOtherQuestion();
      optionsContainer.appendChild(otherBtn);

      messagesContainer.appendChild(optionsContainer);
      scrollToBottom();
    }

    function handleFaqSelect(faq) {
      // Clear options
      const currentOptions = document.getElementById('pmbmCurrentOptions');
      if (currentOptions) currentOptions.remove();

      appendUserBubble(faq.question);
      showTypingIndicator();

      setTimeout(() => {
        removeTypingIndicator();
        appendAssistantBubble(faq.answer);
        
        // Show after-faq menu
        renderFollowUpMenu();
      }, 800);
    }

    function handleOtherQuestion() {
      const currentOptions = document.getElementById('pmbmCurrentOptions');
      if (currentOptions) currentOptions.remove();

      appendUserBubble("Saya ingin bertanya hal lain diluar FAQ");
      showTypingIndicator();

      setTimeout(() => {
        removeTypingIndicator();
        appendAssistantBubble("Mohon maaf jika pertanyaan Anda belum terjawab di sini. Silakan hubungi kami secara langsung melalui halaman Kontak.");
        renderContactRedirectButton();
      }, 500);
    }

    function renderFollowUpMenu() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const optionsContainer = document.createElement('div');
      optionsContainer.className = 'pmbm-chat-options';
      optionsContainer.id = 'pmbmCurrentOptions';
      optionsContainer.style.flexDirection = 'row';
      optionsContainer.style.justifyContent = 'space-between';

      const backBtn = document.createElement('button');
      backBtn.className = 'pmbm-action-btn-outline';
      backBtn.style.flex = '1';
      backBtn.style.marginRight = '8px';
      backBtn.innerText = '⬅ Menu FAQ';
      backBtn.onclick = () => {
        optionsContainer.remove();
        appendUserBubble("Kembali ke menu FAQ");
        showTypingIndicator();
        setTimeout(() => {
          removeTypingIndicator();
          appendAssistantBubble("Silakan pilih pertanyaan yang ingin Anda tanyakan:");
          renderFaqOptions();
        }, 500);
      };

      const contactBtn = document.createElement('a');
      contactBtn.className = 'pmbm-action-btn';
      contactBtn.style.flex = '1';
      contactBtn.innerText = 'Hubungi Kami';
      contactBtn.href = '{{ route("landing.kontak") }}';

      optionsContainer.appendChild(backBtn);
      optionsContainer.appendChild(contactBtn);
      messagesContainer.appendChild(optionsContainer);
      scrollToBottom();
    }

    function renderContactRedirectButton() {
      const messagesContainer = document.getElementById('pmbmChatMessages');
      const optionsContainer = document.createElement('div');
      optionsContainer.className = 'pmbm-chat-options';
      optionsContainer.id = 'pmbmCurrentOptions';

      const contactBtn = document.createElement('a');
      contactBtn.className = 'pmbm-action-btn';
      contactBtn.innerText = 'Ke Halaman Kontak';
      contactBtn.href = '{{ route("landing.kontak") }}';
      optionsContainer.appendChild(contactBtn);

      const backBtn = document.createElement('button');
      backBtn.className = 'pmbm-action-btn-outline';
      backBtn.innerText = '⬅ Kembali ke FAQ';
      backBtn.style.marginTop = '4px';
      backBtn.onclick = () => {
        optionsContainer.remove();
        appendUserBubble("Kembali ke menu FAQ");
        showTypingIndicator();
        setTimeout(() => {
          removeTypingIndicator();
          appendAssistantBubble("Silakan pilih pertanyaan yang ingin Anda tanyakan:");
          renderFaqOptions();
        }, 500);
      };
      optionsContainer.appendChild(backBtn);

      messagesContainer.appendChild(optionsContainer);
      scrollToBottom();
    }
  </script>
</body>
</html>
