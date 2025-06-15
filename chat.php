<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>2-Person Chat Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Material+Icons" rel="stylesheet" />
<style>
  /* Reset */
  *, *::before, *::after {
    box-sizing: border-box;
  }
  body, html {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
      Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: linear-gradient(135deg, #6366f1, #06b6d4);
    color: #ececff;
    display: flex;
    flex-direction: column;
  }

  #app {
    flex-grow: 1;
    display: flex;
    height: calc(100vh - 64px); /* minus header */
    overflow: hidden;
  }

  header {
    height: 64px;
    background: rgba(99, 102, 241, 0.75);
    backdrop-filter: blur(15px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    padding: 0 24px;
    font-weight: 700;
    font-size: 1.4rem;
    color: white;
    user-select: none;
  }

  /* Sidebar for users */
  aside.sidebar {
    width: 280px;
    background: rgba(255 255 255 / 0.1);
    backdrop-filter: blur(18px);
    border-right: 1px solid rgba(255 255 255 / 0.18);
    display: flex;
    flex-direction: column;
  }
  .sidebar header {
    padding: 20px 24px;
    font-size: 1.25rem;
    font-weight: 700;
    border-bottom: 1px solid rgba(255 255 255 / 0.15);
    color: #ececff;
  }
  .user-list {
    flex-grow: 1;
    overflow-y: auto;
    padding: 12px 8px;
  }
  .user-list::-webkit-scrollbar {
    width: 8px;
  }
  .user-list::-webkit-scrollbar-thumb {
    background: #8b5cf6aa;
    border-radius: 4px;
  }

  .user {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 14px;
    border-radius: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    user-select: none;
  }
  .user:hover,
  .user:focus {
    background: rgba(139, 92, 246, 0.3);
    outline: none;
  }
  .user.selected {
    background: #8b5cf6bb;
  }

  .user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 2px 10px rgba(139, 92, 246, 0.4);
  }
  .user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .user-name {
    font-size: 1rem;
    font-weight: 600;
    color: #dedfff;
  }

  /* Chat Main Section */
  main.chat-main {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    background: rgba(255 255 255 / 0.07);
    backdrop-filter: blur(18px);
  }

  /* Chat Header */
  .chat-header {
    height: 64px;
    padding: 0 24px;
    background: rgba(99, 102, 241, 0.75);
    color: white;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid rgba(255 255 255 / 0.12);
    user-select: none;
  }
  .chat-header .chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(139, 92, 246, 0.4);
  }
  .chat-header .chat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .chat-header .chat-username {
    font-weight: 700;
    font-size: 1.1rem;
  }

  /* Messages container */
  .messages {
    flex-grow: 1;
    padding: 24px 24px 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  .messages::-webkit-scrollbar {
    width: 8px;
  }
  .messages::-webkit-scrollbar-thumb {
    background: #8b5cf6aa;
    border-radius: 4px;
  }
  /* Individual message bubbles */
  .message {
    max-width: 75%;
    padding: 12px 18px;
    border-radius: 20px;
    font-size: 1rem;
    line-height: 1.3;
    position: relative;
    word-wrap: break-word;
    user-select: text;
  }
  .message.from-me {
    align-self: flex-end;
    background: linear-gradient(135deg, #8b5cf6, #06b6d4);
    color: white;
    border-bottom-right-radius: 4px;
    box-shadow: 0 6px 18px rgba(13, 71, 161, 0.5);
  }
  .message.from-them {
    align-self: flex-start;
    background: rgba(255 255 255 / 0.15);
    color: #e0e0ffdd;
    border-bottom-left-radius: 4px;
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
  }
  .message .timestamp {
    font-size: 0.68rem;
    opacity: 0.45;
    position: absolute;
    bottom: -18px;
    right: 14px;
    user-select: none;
  }

  /* Chat Input area */
  form.message-form {
    padding: 16px 24px;
    background: rgba(255 255 255 / 0.1);
    backdrop-filter: blur(18px);
    display: flex;
    gap: 16px;
    border-top: 1px solid rgba(255 255 255 / 0.18);
  }
  form.message-form input[type="text"] {
    flex-grow: 1;
    padding: 12px 18px;
    border-radius: 32px;
    border: none;
    font-size: 1rem;
    outline-offset: 3px;
    outline-color: transparent;
    background: rgba(255 255 255 / 0.15);
    color: #ececff;
    transition: background-color 0.3s ease;
  }
  form.message-form input[type="text"]::placeholder {
    color: #b0b0ff99;
  }
  form.message-form input[type="text"]:focus {
    background: rgba(255 255 255 / 0.25);
    outline-color: #8b5cf6;
  }
  form.message-form button.send-btn {
    background: #8b5cf6;
    border: none;
    padding: 0 18px;
    border-radius: 32px;
    cursor: pointer;
    color: white;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }
  form.message-form button.send-btn:hover,
  form.message-form button.send-btn:focus {
    background: #06b6d4;
    outline: none;
    transform: scale(1.1);
  }
  form.message-form button.send-btn:active {
    transform: scale(1);
  }

  /* Responsive */
  @media (max-width: 768px) {
    #app {
      flex-direction: column;
      height: auto;
    }
    aside.sidebar {
      width: 100%;
      height: 80px;
      flex-direction: row;
      border-right: none;
      border-bottom: 1px solid rgba(255 255 255 / 0.18);
    }
    .user-list {
      display: flex;
      flex-direction: row;
      overflow-x: auto;
      padding: 0 8px;
    }
    .user {
      flex-direction: column;
      padding: 6px 10px;
      min-width: 72px;
      justify-content: center;
      text-align: center;
      gap: 6px;
      font-size: 0.9rem;
    }
    .user-name {
      font-size: 0.85rem;
    }
    main.chat-main {
      height: auto;
      flex-grow: unset;
    }
    .messages {
      padding: 12px 12px 10px;
      max-height: 50vh;
    }
  }

</style>
</head>
<body>
<header>
  Chat Dashboard
</header>

<div id="app" role="main">
  <aside class="sidebar" aria-label="Chat users list">
    <header>Chats</header>
    <div class="user-list" tabindex="0" aria-live="polite" aria-relevant="additions removals">
      <div class="user selected" role="button" tabindex="0" aria-pressed="true" data-userid="1" aria-label="Chat with Alice">
        <div class="user-avatar">
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/b044316b-04cc-4d35-b417-c115215a2406.png" alt="Avatar for Alice" />
        </div>
        <span class="user-name">Alice</span>
      </div>
      <div class="user" role="button" tabindex="0" aria-pressed="false" data-userid="2" aria-label="Chat with Bob">
        <div class="user-avatar">
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c5703014-7edc-4804-9d71-3b0295d7d2ce.png" alt="Avatar for Bob" />
        </div>
        <span class="user-name">Bob</span>
      </div>
    </div>
  </aside>

  <main class="chat-main" aria-label="Chat conversation area">
    <header class="chat-header" role="banner" aria-live="polite" aria-atomic="true">
      <div class="chat-avatar" aria-hidden="true">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c76d64d3-4016-4a3b-90be-9c4849d1298a.png" alt="" />
      </div>
      <div class="chat-username">Alice</div>
    </header>

    <section class="messages" role="log" aria-live="polite" aria-relevant="additions" tabindex="0">
      <!-- Messages go here -->
    </section>

    <form class="message-form" aria-label="Send message form" autocomplete="off">
      <input type="text" id="messageInput" name="message" aria-label="Type your message" placeholder="Type a message..." required />
      <button type="submit" class="send-btn" aria-label="Send message">
        <span class="material-icons">send</span>
      </button>
    </form>
  </main>
</div>

<script>
  (() => {
    const users = {
      1: {
        id: 1,
        name: "Alice",
        avatar: "https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/5e08fea4-40bf-430b-a975-be5194093aaa.png"
      },
      2: {
        id: 2,
        name: "Bob",
        avatar: "https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/bb54b766-9e06-4d4e-982a-9d617503c04a.png"
      }
    };

    // Messages for each user: array of {sender: 1|2, text, timestamp}
    const conversations = {
      1: [
        { sender: 1, text: "Hey! How are you?", timestamp: new Date().getTime() - 600000 },
        { sender: 2, text: "Hi! I'm good, thanks. How about you?", timestamp: new Date().getTime() - 550000 },
        { sender: 1, text: "Doing great, working on our project.", timestamp: new Date().getTime() - 500000 }
      ],
      2: [
        { sender: 2, text: "Hello Bob, ready for the meeting today?", timestamp: new Date().getTime() - 700000 },
        { sender: 1, text: "Hi Alice, yes, almost done prepping.", timestamp: new Date().getTime() - 650000 }
      ]
    };

    const userListEl = document.querySelector('.user-list');
    const messageContainer = document.querySelector('.messages');
    const chatHeaderName = document.querySelector('.chat-username');
    const chatHeaderAvatar = document.querySelector('.chat-avatar img');
    const messageForm = document.querySelector('.message-form');
    const messageInput = document.getElementById('messageInput');

    let currentChatUserId = 1;

    // Format timestamp to HH:mm
    function formatTime(ts) {
      const d = new Date(ts);
      return d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    // Render messages
    function renderMessages(userId) {
      messageContainer.innerHTML = '';
      const msgs = conversations[userId] || [];
      msgs.forEach(msg => {
        const msgEl = document.createElement('div');
        msgEl.classList.add('message');
        msgEl.classList.add(msg.sender === currentChatUserId ? 'from-me' : 'from-them');
        msgEl.textContent = msg.text;

        const timeEl = document.createElement('span');
        timeEl.classList.add('timestamp');
        timeEl.textContent = formatTime(msg.timestamp);
        msgEl.appendChild(timeEl);

        messageContainer.appendChild(msgEl);
      });
      messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    // Update chat header info
    function updateChatHeader(userId) {
      const user = users[userId];
      chatHeaderName.textContent = user.name;
      chatHeaderAvatar.src = user.avatar;
      chatHeaderAvatar.alt = `Avatar for ${user.name}`;
    }

    // Switch selected user highlight & aria
    function updateSelectedUser(newUserId) {
      const allUsers = userListEl.querySelectorAll('.user');
      allUsers.forEach(userEl => {
        const uid = Number(userEl.getAttribute('data-userid'));
        if (uid === newUserId) {
          userEl.classList.add('selected');
          userEl.setAttribute('aria-pressed', 'true');
          userEl.focus();
        } else {
          userEl.classList.remove('selected');
          userEl.setAttribute('aria-pressed', 'false');
        }
      });
    }

    // Handle user selection
    userListEl.addEventListener('click', e => {
      const userEl = e.target.closest('.user');
      if (!userEl) return;

      const uid = Number(userEl.getAttribute('data-userid'));
      if (uid === currentChatUserId) return;

      currentChatUserId = uid;
      updateSelectedUser(uid);
      updateChatHeader(uid);
      renderMessages(uid);
      messageInput.value = '';
      messageInput.focus();
    });

    // Keyboard navigation for users list
    userListEl.addEventListener('keydown', e => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      const userEl = e.target.closest('.user');
      if (!userEl) return;
      userEl.click();
    });

    // Send message handler
    messageForm.addEventListener('submit', e => {
      e.preventDefault();
      const msgText = messageInput.value.trim();
      if (!msgText) return;
      const now = new Date().getTime();

      // Add message as "me" (currentChatUserId)
      conversations[currentChatUserId] = conversations[currentChatUserId] || [];
      conversations[currentChatUserId].push({
        sender: currentChatUserId,
        text: msgText,
        timestamp: now
      });
      renderMessages(currentChatUserId);
      messageInput.value = '';
      messageInput.focus();

      // Simulate a reply from the other user with a short delay
      setTimeout(() => {
        const otherUserId = currentChatUserId === 1 ? 2 : 1;
        conversations[currentChatUserId].push({
          sender: otherUserId,
          text: "Got it!",
          timestamp: new Date().getTime()
        });
        renderMessages(currentChatUserId);
      }, 1200);
    });

    // Initialization
    updateSelectedUser(currentChatUserId);
    updateChatHeader(currentChatUserId);
    renderMessages(currentChatUserId);
  })();
</script>
</body>
</html>

