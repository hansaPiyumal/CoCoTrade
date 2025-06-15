<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>User Profile Dashboard</title>
<link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Material+Icons"
  rel="stylesheet"
/>
<style>
  /* Reset and base */
  *, *::before, *::after {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
      Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: linear-gradient(135deg, #6366f1, #06b6d4);
    color: #ececff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* Header */
  header {
    backdrop-filter: blur(20px);
    background: rgba(99, 102, 241, 0.7);
    padding: 16px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0 0 0 / 0.2);
    position: sticky;
    top: 0;
    z-index: 100;
  }
  .logo {
    font-weight: 800;
    font-size: 1.8rem;
    letter-spacing: 2px;
    cursor: default;
    background: linear-gradient(135deg, #8b5cf6, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    user-select: none;
  }
  nav {
    display: flex;
    gap: 32px;
  }
  nav a {
    color: #d3d3ffcc;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 12px;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  nav a:hover,
  nav a:focus-visible {
    background: #8b5cf6;
    color: white;
    outline-offset: 4px;
    outline: 2px solid #8b5cf6;
  }

  /* Main container */
  main {
    flex-grow: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 48px 24px;
  }

  /* Profile card */
  .profile-card {
    background: rgba(255 255 255 / 0.1);
    border-radius: 24px;
    backdrop-filter: blur(18px);
    box-shadow: 0 24px 48px rgba(99, 102, 241, 0.25);
    padding: 48px 64px;
    max-width: 480px;
    width: 100%;
    text-align: center;
    user-select: text;
  }

  /* Profile image */
  .profile-avatar {
    width: 130px;
    height: 130px;
    margin: 0 auto 32px;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(99, 102, 241, 0.45);
    border: 4px solid #8b5cf6;
  }
  .profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Username */
  .profile-username {
    font-weight: 800;
    font-size: 2.4rem;
    margin-bottom: 24px;
    background: linear-gradient(135deg, #8b5cf6, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  /* Info list */
  .info-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 40px;
  }
  .info-item {
    background: rgba(255 255 255 / 0.15);
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 12px 38px rgba(99, 102, 241, 0.3);
    font-size: 1.2rem;
    font-weight: 600;
    color: #ececff;
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .info-item .material-icons {
    font-size: 30px;
    background: linear-gradient(135deg, #8b5cf6, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    user-select: none;
    flex-shrink: 0;
  }
  .info-label {
    flex: 0 0 140px;
    text-align: left;
    font-weight: 700;
    font-size: 1rem;
    opacity: 0.7;
    user-select: none;
  }
  .info-value {
    text-align: left;
    flex-grow: 1;
    word-break: break-word;
  }

  /* Edit profile button */
  .btn-edit {
    background: linear-gradient(135deg, #06b6d4, #8b5cf6);
    border: none;
    padding: 16px 48px;
    border-radius: 16px;
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    user-select: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
  }
  .btn-edit:hover,
  .btn-edit:focus-visible {
    outline-offset: 4px;
    outline: 3px solid #8b5cf6;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
  }
  .btn-edit .material-icons {
    font-size: 24px;
  }

  /* Responsive */
  @media (max-width: 500px) {
    main {
      padding: 32px 16px;
    }
    .profile-card {
      padding: 36px 24px;
      max-width: 100%;
    }
    .profile-username {
      font-size: 1.8rem;
      margin-bottom: 20px;
    }
    .info-item {
      font-size: 1rem;
      padding: 16px 18px;
      gap: 12px;
    }
    .info-label {
      flex: none;
      width: auto;
      font-size: 0.9rem;
    }
  }

  /* Accessibility */
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    border: 0;
    overflow: hidden;
    clip: rect(0 0 0 0);
    clip-path: inset(100%);
    white-space: nowrap;
  }
</style>
</head>
<body>
<header aria-label="Application header">
  <div class="logo" tabindex="0">NoteMaster Pro</div>
  <nav aria-label="Primary navigation">
    <a href="#" tabindex="0">Home</a>
    <a href="#" tabindex="0">Notes</a>
    <a href="#" tabindex="0" aria-current="page">Profile</a>
    <a href="#" tabindex="0">Settings</a>
  </nav>
</header>

<main>
  <article class="profile-card" role="main" aria-labelledby="profileTitle">
    <h1 id="profileTitle" class="sr-only">User Profile Dashboard</h1>
    <div class="profile-avatar" aria-label="User profile picture">
      <img
        src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/3b0f54f0-7f74-44e2-9c8a-e6402b12f61e.png"
        alt="Profile image showing a user avatar with abstract purple and blue background"
        width="130"
        height="130"
        decoding="async"
        loading="lazy"
      />
    </div>

    <h2 class="profile-username" tabindex="0">john_doe</h2>

    <section class="info-list" aria-label="User profile information">
      <div class="info-item">
        <span class="material-icons" aria-hidden="true" title="Contact phone number">phone</span>
        <span class="info-label">Contact Number</span>
        <span class="info-value" tabindex="0">+1 (555) 123-4567</span>
      </div>
      <div class="info-item">
        <span class="material-icons" aria-hidden="true" title="Email address">email</span>
        <span class="info-label">Email Address</span>
        <span class="info-value" tabindex="0">john_doe@example.com</span>
      </div>
      <div class="info-item">
        <span class="material-icons" aria-hidden="true" title="Order count">shopping_cart</span>
        <span class="info-label">Order Count</span>
        <span class="info-value" tabindex="0">42</span>
      </div>
    </section>

    <button class="btn-edit" type="button" aria-label="Edit profile">
      <span class="material-icons" aria-hidden="true">edit</span> Edit Profile
    </button>
  </article>
</main>
</body>
</html>

