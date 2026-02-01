<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Coin Trade</title>
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
        <div class="page-breadcrumb">Home / Account / Login</div>
        <h1 class="page-title">Welcome <span>back</span></h1>
        <p class="page-subtitle">Sign in to review your mining performance, manage payouts, and monitor live trading insights.</p>
      </div>
      <div class="page-hero-card">
        <div class="badge"><i class="fa-solid fa-shield" aria-hidden="true"></i> Secure access</div>
        <h3>Protected sessions</h3>
        <p>We enforce device approvals, live login alerts, and multi-factor security to keep your account safe.</p>
      </div>
    </section>

    <section class="auth-layout">
      <div class="auth-panel glass">
        <div>
          <h2 class="auth-title">Login to your <span>dashboard</span></h2>
          <p class="auth-subtitle">Use the same credentials you set up during onboarding. Need a new account? You can create one in minutes.</p>
        </div>

        <form class="auth-form" action="#" method="post">
          <label class="form-field">
            Email address
            <input type="email" name="email" placeholder="you@company.com" required>
          </label>

          <label class="form-field">
            Password
            <input type="password" name="password" placeholder="Enter your password" required>
          </label>

          <div class="auth-row">
            <label class="checkbox-row">
              <input type="checkbox" name="remember" checked>
              <span>Remember this device</span>
            </label>
            <a href="#">Forgot password?</a>
          </div>

          <div class="auth-actions">
            <button class="primary-btn" type="submit">Access my account</button>
            <div class="auth-alt">New here? <a href="signup.php">Create a secure account</a></div>
          </div>
        </form>
      </div>

      <aside class="auth-side glass">
        <div class="auth-cta">
          <div class="badge"><i class="fa-solid fa-bolt" aria-hidden="true"></i> Real-time access</div>
          <h3>Everything in one control room</h3>
          <p class="page-subtitle">Track hashpower plans, automated trading strategies, and ROI forecasts in a single workspace.</p>
        </div>
        <ul class="auth-list">
          <li>Monitor live earnings, payouts, and vault balances.</li>
          <li>Update compliance documents and security preferences.</li>
          <li>Activate smart alerts for market movements.</li>
          <li>Access priority support with verified status.</li>
        </ul>
        <div class="card">
          <h4>Need help signing in?</h4>
          <p>Visit the <a href="help-center.php">Help Center</a> or reach out to our support desk for recovery support.</p>
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
