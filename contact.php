<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact | Coin Trade</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="page.css" />
</head>
<body>
  <div class="bg-3d" aria-hidden="true">
    <div class="scene" id="cubeScene"></div>
  </div>
  <div class="wrap">
    <header class="heroNav">
      <a class="brand" href="index.php" aria-label="wexon">
          <picture>
            <source media="(max-width: 768px)" srcset="img/412.png">
            <img src="img/700.png" alt="Wexon logo" loading="lazy" decoding="async">
          </picture>
        </a>

      <nav class="heroLinks" aria-label="Primary">
        <a href="index.php">Home</a>
        <a href="faq.php">FAQ</a>
        <a href="help-center.php">Help Center</a>
        <a href="contact.php">Contact</a>
        <a href="legal.php">Legal</a>
      </nav>

      <div class="heroRightNav">
        <div class="langPill" aria-label="Language">
          <span style="opacity:.9">🌐</span>
          <span>EN</span>
        </div>
        <a class="pillBtn ghost" href="login.php">Login</a>
        <a class="pillBtn" href="signup.php">Sign up</a>
      </div>
    </header>

    <section class="page-hero glass">
      <div>
        <div class="page-breadcrumb">Home / Support / Contact</div>
        <h1 class="page-title">Contact <span>Support</span></h1>
        <p class="page-subtitle">Reach the Coin Trade team for account issues, compliance questions, or enterprise partnerships.</p>
      </div>
      <div class="page-hero-card">
        <div class="badge"><i class="fa-solid fa-headset" aria-hidden="true"></i> 24/7 Coverage</div>
        <h3>Support queue</h3>
        <p>Priority requests are answered within 2 hours.</p>
        <p><strong>Email:</strong> support@cointrade.io</p>
      </div>
    </section>

    <section class="page-section">
      <h2 class="section-title">Send us a message</h2>
      <div class="glass" style="padding:20px;">
        <form>
          <div class="form-grid">
            <label class="form-field">
              Full name
              <input type="text" placeholder="Avery Singh" />
            </label>
            <label class="form-field">
              Email address
              <input type="email" placeholder="avery@company.com" />
            </label>
            <label class="form-field">
              Topic
              <div class="country-select">
                <input type="text" name="topic" placeholder="Choose a topic" autocomplete="off" aria-autocomplete="list" aria-controls="topic-options" />
                <div class="country-options" id="topic-options" role="listbox" aria-label="Topic list"></div>
              </div>
            </label>
          </div>
          <label class="form-field" style="margin-top:14px;">
            Message
            <textarea placeholder="Tell us how we can help..."></textarea>
          </label>
          <div style="margin-top:16px;">
            <button class="primary-btn" type="button">Submit request</button>
          </div>
        </form>
      </div>
    </section>

    <section class="page-section">
      <h2 class="section-title">Other ways to connect</h2>
      <div class="page-grid">
        <article class="card">
          <h4><i class="fa-solid fa-location-dot" aria-hidden="true"></i> HQ office</h4>
          <p>110 King Street West, Toronto, ON M5X 1A9, Canada</p>
        </article>
        <article class="card">
          <h4><i class="fa-solid fa-envelope" aria-hidden="true"></i> Compliance</h4>
          <p>Report suspicious activity or submit legal requests via compliance@cointrade.io.</p>
        </article>
        <article class="card">
          <h4><i class="fa-solid fa-phone" aria-hidden="true"></i> Enterprise line</h4>
          <p>+1 (416) 555-0198, Monday to Friday, 8:00 AM – 6:00 PM EST.</p>
        </article>
      </div>
    </section>

    <footer class="site-footer glass">
      <div class="footer-grid">
        <div class="footer-brand">
          <img class="footer-logo" src="img/412.png" alt="Wexon logo" loading="lazy" decoding="async">
          <div class="footer-icons" aria-label="Social links">
            <a class="footer-icon" href="#" aria-label="Telegram">
              <i class="fa-brands fa-telegram" aria-hidden="true"></i>
            </a>
            <a class="footer-icon" href="#" aria-label="X">
              <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
            </a>
            <a class="footer-icon" href="#" aria-label="LinkedIn">
              <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
            </a>
            <a class="footer-icon" href="#" aria-label="Discord">
              <i class="fa-brands fa-discord" aria-hidden="true"></i>
            </a>
          </div>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Quick Links</h3>
          <ul class="footer-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Markets</a></li>
            <li><a href="#">About</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Support</h3>
          <ul class="footer-links">
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="help-center.php">Help Center</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Legal</h3>
          <ul class="footer-links">
            <li><a href="privacy-policy.php">Privacy Policy</a></li>
            <li><a href="terms-of-service.php">Terms of Service</a></li>
            <li><a href="cookie-policy.php">Cookie Policy</a></li>
            <li><a href="compliance.php">Compliance</a></li>
          </ul>
        </div>

        <div class="footer-column app-col">
          <h3 class="footer-heading">Download App</h3>
          <div class="footer-apps">
            <a class="footer-app-btn" href="#" aria-label="Download on the App Store">
              <i class="fa-brands fa-apple" aria-hidden="true"></i>
              App Store
            </a>
            <a class="footer-app-btn" href="#" aria-label="Get it on Google Play">
              <i class="fa-brands fa-google-play" aria-hidden="true"></i>
              Google Play
            </a>
          </div>
        </div>

        <p class="footer-copy footer-copy-wide">Canada's leading cryptocurrency trading platform. Trade with confidence, security, and speed.</p>
      </div>

      <div class="footer-bottom">
        <span>© 2026. All rights reserved.</span>
        <span>Built for fast, secure, and compliant crypto trading.</span>
      </div>
    </footer>
  </div>
  <script src="page-bg.js"></script>
  <script>
    const topicInput = document.querySelector('input[name="topic"]');
    const topicOptions = document.getElementById('topic-options');
    const topics = [
      'Account & access',
      'Deposits & withdrawals',
      'Compliance review',
      'Partnership inquiry'
    ];
    let activeTopicIndex = -1;

    const closeTopicList = () => {
      topicOptions.classList.remove('show');
      activeTopicIndex = -1;
      updateActiveTopic();
    };

    const updateActiveTopic = () => {
      const options = [...topicOptions.querySelectorAll('.country-option')];
      options.forEach((option, index) => {
        option.classList.toggle('active', index === activeTopicIndex);
      });
    };

    const buildTopicOptions = (query) => {
      const lowerQuery = query.trim().toLowerCase();
      const matches = topics.filter((topic) =>
        topic.toLowerCase().includes(lowerQuery)
      );
      topicOptions.innerHTML = '';

      matches.forEach((topic, index) => {
        const option = document.createElement('button');
        option.type = 'button';
        option.className = 'country-option';
        option.role = 'option';
        option.textContent = topic;
        option.addEventListener('click', () => {
          topicInput.value = topic;
          closeTopicList();
        });
        option.addEventListener('mousemove', () => {
          activeTopicIndex = index;
          updateActiveTopic();
        });
        topicOptions.appendChild(option);
      });

      if (matches.length) {
        topicOptions.classList.add('show');
      } else {
        closeTopicList();
      }
    };

    topicInput.addEventListener('input', (event) => {
      buildTopicOptions(event.target.value);
    });

    topicInput.addEventListener('focus', () => {
      buildTopicOptions(topicInput.value || '');
    });

    topicInput.addEventListener('keydown', (event) => {
      const options = [...topicOptions.querySelectorAll('.country-option')];
      if (!options.length) {
        return;
      }

      if (event.key === 'ArrowDown') {
        event.preventDefault();
        activeTopicIndex = (activeTopicIndex + 1) % options.length;
        updateActiveTopic();
        options[activeTopicIndex].scrollIntoView({ block: 'nearest' });
      }

      if (event.key === 'ArrowUp') {
        event.preventDefault();
        activeTopicIndex = (activeTopicIndex - 1 + options.length) % options.length;
        updateActiveTopic();
        options[activeTopicIndex].scrollIntoView({ block: 'nearest' });
      }

      if (event.key === 'Enter' && activeTopicIndex >= 0) {
        event.preventDefault();
        options[activeTopicIndex].click();
      }

      if (event.key === 'Escape') {
        closeTopicList();
      }
    });

    topicInput.addEventListener('blur', () => {
      setTimeout(closeTopicList, 120);
    });
  </script>
</body>
</html>
