<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Coin Trade</title>
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
        <div class="page-breadcrumb">Home / Account / Sign up</div>
        <h1 class="page-title">Create your <span>account</span></h1>
        <p class="page-subtitle">Start trading and mining with trusted compliance tools, market alerts, and a dedicated support team.</p>
      </div>
      <div class="page-hero-card">
        <div class="badge"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Fast onboarding</div>
        <h3>Go live in minutes</h3>
        <p>Complete profile details, verify your identity, and connect your payout wallet.</p>
      </div>
    </section>

    <section class="auth-layout">
      <div class="auth-panel glass">
        <div>
          <h2 class="auth-title">Join the <span>Coin Trade</span> network</h2>
          <p class="auth-subtitle">Create a secure profile to access our mining suites, advanced analytics, and smart trading workflows.</p>
        </div>

        <form class="auth-form" action="#" method="post">
          <div class="form-grid">
            <label class="form-field">
              First name
              <input type="text" name="first_name" placeholder="Amelia" required>
            </label>
            <label class="form-field">
              Last name
              <input type="text" name="last_name" placeholder="Nguyen" required>
            </label>
            <label class="form-field">
              Work email
              <input type="email" name="email" placeholder="you@company.com" required>
            </label>
            <label class="form-field">
              Country/Region
              <select class="glassy-select" name="country" required>
                <option value="" selected disabled>Select your region</option>
                <option value="ca">Canada</option>
                <option value="us">United States</option>
                <option value="gb">United Kingdom</option>
                <option value="eu">European Union</option>
                <option value="apac">APAC</option>
              </select>
            </label>
          </div>

          <label class="form-field">
            Create password
            <input type="password" name="password" placeholder="Use 10+ characters" required>
          </label>

          <label class="form-field">
            Confirm password
            <input type="password" name="confirm_password" placeholder="Re-enter password" required>
          </label>

          <div class="auth-row">
            <label class="checkbox-row">
              <input type="checkbox" name="terms" required>
              <span>I agree to the Terms of Service and Privacy Policy.</span>
            </label>
          </div>

          <div class="auth-actions">
            <button class="primary-btn" type="submit">Create my account</button>
            <div class="auth-alt">Already have access? <a href="login.php">Log in here</a></div>
          </div>
        </form>
      </div>

      <aside class="auth-side glass">
        <div class="auth-cta">
          <div class="badge"><i class="fa-solid fa-chart-line" aria-hidden="true"></i> Built for growth</div>
          <h3>Unlock premium analytics</h3>
          <p class="page-subtitle">Gain daily ROI projections, live risk tracking, and proactive alerts from the moment you sign up.</p>
        </div>
        <ul class="auth-list">
          <li>Instant access to mining plans and trading bots.</li>
          <li>Dedicated compliance guidance for new accounts.</li>
          <li>Personalized alerts for portfolio milestones.</li>
          <li>Priority onboarding sessions with our experts.</li>
        </ul>
        <div class="card">
          <h4>Questions before joining?</h4>
          <p>Review our <a href="faq.php">FAQ</a> or connect with the <a href="contact.php">support team</a> for guidance.</p>
        </div>
      </aside>
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
            <li><a href="index.php">Home</a></li>
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
</body>
</html>
