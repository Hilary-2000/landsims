<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Privacy Policy — Ladybird School Management System</title>
<!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<style>
  :root {
    --green-deep: #1a3a2a;
    --green-mid: #2d6a4f;
    --green-light: #52b788;
    --green-pale: #d8f3dc;
    --cream: #fdfaf5;
    --text-dark: #1c1c1c;
    --text-mid: #444;
    --text-light: #777;
    --border: #e0ede5;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Open Sans', 'Nunito';
    background: var(--cream);
    color: var(--text-dark);
    line-height: 1.8;
  }

  header {
    background: var(--green-deep);
    padding: 48px 0 40px;
    position: relative;
    overflow: hidden;
  }

  header::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(82,183,136,0.08);
  }

  header::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 10%;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(82,183,136,0.05);
  }

  .header-inner {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 32px;
    position: relative;
    z-index: 1;
  }

  .logo-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
  }

  .logo-bug {
    width: 44px; height: 44px;
    background: var(--green-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
  }

  .logo-text {
    font-family: 'Open Sans', 'Poppins';
    font-size: 18px;
    color: #fff;
    letter-spacing: 0.02em;
  }

  .logo-sub {
    font-family: 'Open Sans', 'Nunito';
    font-size: 11px;
    font-weight: 300;
    color: var(--green-light);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    display: block;
    margin-top: 1px;
  }

  header h1 {
    font-family: 'Nunito';
    font-size: clamp(28px, 5vw, 42px);
    font-weight: 600;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 12px;
  }

  .header-meta {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
  }

  .header-meta span {
    font-size: 13px;
    color: var(--green-light);
    font-weight: 300;
  }

  .header-meta span strong {
    color: #fff;
    font-weight: 500;
  }

  .main-wrap {
    max-width: 860px;
    margin: 0 auto;
    padding: 60px 32px 100px;
  }

  .intro-box {
    background: var(--green-pale);
    border-left: 4px solid var(--green-light);
    border-radius: 0 12px 12px 0;
    padding: 24px 28px;
    margin-bottom: 56px;
    font-size: 15px;
    color: var(--green-deep);
    line-height: 1.7;
  }

  .intro-box strong {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: 500;
  }

  section {
    margin-bottom: 52px;
  }

  .section-number {
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--green-light);
    margin-bottom: 6px;
  }

  h2 {
    font-family: 'Nunito';
    font-size: 22px;
    font-weight: 600;
    color: var(--green-deep);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
  }

  p {
    font-size: 15px;
    color: var(--text-mid);
    margin-bottom: 14px;
    font-weight: 300;
  }

  ul, ol {
    margin: 12px 0 16px 0;
    padding-left: 0;
    list-style: none;
  }

  ul li, ol li {
    font-size: 15px;
    color: var(--text-mid);
    font-weight: 300;
    padding: 8px 0 8px 28px;
    position: relative;
    border-bottom: 1px solid var(--border);
  }

  ul li:last-child, ol li:last-child {
    border-bottom: none;
  }

  ul li::before {
    content: '';
    position: absolute;
    left: 0; top: 17px;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--green-light);
  }

  ol {
    counter-reset: item;
  }

  ol li {
    counter-increment: item;
  }

  ol li::before {
    content: counter(item);
    position: absolute;
    left: 0; top: 8px;
    width: 20px; height: 20px;
    background: var(--green-deep);
    color: #fff;
    border-radius: 50%;
    font-size: 11px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'DM Sans', sans-serif;
  }

  .provider-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin: 20px 0;
  }

  .provider-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
  }

  .provider-card .provider-name {
    font-weight: 500;
    font-size: 14px;
    color: var(--green-deep);
    margin-bottom: 4px;
  }

  .provider-card .provider-role {
    font-size: 13px;
    color: var(--text-light);
    font-weight: 300;
    line-height: 1.5;
  }

  .rights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    margin: 20px 0;
  }

  .right-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }

  .right-dot {
    width: 10px; height: 10px;
    min-width: 10px;
    border-radius: 50%;
    background: var(--green-light);
    margin-top: 5px;
  }

  .right-text {
    font-size: 14px;
    color: var(--text-mid);
    font-weight: 300;
    line-height: 1.5;
  }

  .contact-box {
    background: var(--green-deep);
    border-radius: 16px;
    padding: 36px 40px;
    color: #fff;
    margin-top: 20px;
  }

  .contact-box h3 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: 600;
  }

  .contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
  }

  .contact-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .contact-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--green-light);
    font-weight: 500;
  }

  .contact-value {
    font-size: 15px;
    color: #fff;
    font-weight: 300;
  }

  .contact-value a {
    color: var(--green-light);
    text-decoration: none;
  }

  .stop-note {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px 20px;
    margin-top: 16px;
    font-size: 14px;
    color: var(--text-mid);
    font-weight: 300;
  }

  .stop-note strong {
    color: var(--green-deep);
    font-weight: 500;
  }

  footer {
    background: var(--green-deep);
    padding: 24px 32px;
    text-align: center;
  }

  footer p {
    color: rgba(255,255,255,0.4);
    font-size: 13px;
    margin: 0;
  }

  @media (max-width: 600px) {
    .main-wrap { padding: 40px 20px 80px; }
    .contact-box { padding: 28px 24px; }
    header { padding: 36px 0 32px; }
  }
</style>
</head>
<body>

<header>
  <div class="header-inner">
    <div class="logo-row">
      <div class="logo-bug"><img width="40" src="assets/img/ladybird_white-removebg.png" alt=""></div>
      <div>
        <span class="logo-text">Ladybird Softech Co.</span>
        <span class="logo-sub">School Management System</span>
      </div>
    </div>
    <h1>Privacy Policy</h1>
    <div class="header-meta">
      <span><strong>Effective Date:</strong> April 2026</span>
      <span><strong>Last Updated:</strong> April 2026</span>
      <span><strong>Version:</strong> 1.0</span>
    </div>
  </div>
</header>

<div class="main-wrap">

  <div class="intro-box">
    <strong>Our commitment to your privacy</strong>
    This Privacy Policy explains how Ladybird Softech Co. collects, uses, stores and protects your personal information when you use the Ladybird School Management System (LSMIS) or interact with our WhatsApp Business messaging service. We are committed to handling your data responsibly and in compliance with applicable data protection laws.
  </div>

  <section>
    <div class="section-number">01</div>
    <h2>Who We Are</h2>
    <p>Ladybird Softech Co. is a Kenyan technology company that develops and provides the Ladybird School Management Information System (LSMIS) — a cloud-based school management platform designed for schools, colleges and universities in Kenya.</p>
    <p>We also operate a WhatsApp Business AI assistant named <strong>Gloria</strong> that responds to inquiries from schools and educational institutions interested in our system.</p>
    <ul>
      <li><strong>Company Name:</strong> Ladybird Softech Co.</li>
      <li><strong>Location:</strong> Thika, Kiambu, Kenya</li>
      <li><strong>Website:</strong> https://ladybirdsmis.com</li>
      <li><strong>Contact Email:</strong> mail@ladybirdsmis.com</li>
      <li><strong>Phone:</strong> +254743551250</li>
    </ul>
  </section>

  <section>
    <div class="section-number">02</div>
    <h2>Information We Collect</h2>
    <p>We collect information in two contexts — through our school management system and through our WhatsApp Business messaging service.</p>

    <p><strong>Through the Ladybird School Management System (LSMIS):</strong></p>
    <ul>
      <li>School name, address, and registration details</li>
      <li>Administrator, staff and teacher names and contact information</li>
      <li>Student names, admission numbers and academic records</li>
      <li>Parent and guardian contact information</li>
      <li>Fee payment records and financial data</li>
      <li>Attendance records for students and staff</li>
      <li>Academic performance data including marks and grades</li>
    </ul>

    <p><strong>Through our WhatsApp Business AI Assistant (Gloria):</strong></p>
    <ul>
      <li>Your WhatsApp phone number</li>
      <li>Your WhatsApp display name</li>
      <li>Message content you send to our business number</li>
      <li>Date and time of messages</li>
      <li>Your school name and level if shared during conversation</li>
    </ul>
  </section>

  <section>
    <div class="section-number">03</div>
    <h2>How We Use Your Information</h2>
    <p>We use your information only for legitimate business purposes directly related to providing and improving our services.</p>
    <ul>
      <li>To respond to your inquiries about the Ladybird School Management System</li>
      <li>To schedule and conduct product demonstration sessions</li>
      <li>To follow up on your interest in our products and services</li>
      <li>To provide system access, training and ongoing support to schools</li>
      <li>To process fee payments and generate receipts within the school system</li>
      <li>To send SMS notifications to parents and staff via the Communication module</li>
      <li>To generate academic reports and student performance records</li>
      <li>To improve our AI assistant and customer service quality</li>
    </ul>
  </section>

  <section>
    <div class="section-number">04</div>
    <h2>Legal Basis for Processing</h2>
    <p>We process your personal data on the following legal bases:</p>
    <ol>
      <li><strong>Contractual necessity</strong> — to fulfil our service agreement with schools using LSMIS</li>
      <li><strong>Legitimate interests</strong> — to respond to inquiries and follow up with potential clients who have contacted us first</li>
      <li><strong>Consent</strong> — for marketing communications, which you can withdraw at any time</li>
      <li><strong>Legal obligation</strong> — where required by Kenyan law or regulatory requirements</li>
    </ol>
  </section>

  <section>
    <div class="section-number">05</div>
    <h2>Third-Party Service Providers</h2>
    <p>To operate our services we share data with trusted third-party providers. All providers are contractually required to protect your data.</p>

    <div class="provider-grid">
      <div class="provider-card">
        <div class="provider-name">Anthropic (Claude AI)</div>
        <div class="provider-role">Powers our AI assistant Gloria to generate intelligent responses to inquiries</div>
      </div>
      <div class="provider-card">
        <div class="provider-name">Google LLC</div>
        <div class="provider-role">Google Sheets used as our CRM to store client conversation records</div>
      </div>
      <div class="provider-card">
        <div class="provider-name">DigitalOcean</div>
        <div class="provider-role">Hosts our application servers in the London region</div>
      </div>
      <div class="provider-card">
        <div class="provider-name">Meta Platforms</div>
        <div class="provider-role">WhatsApp Business API used to send and receive messages</div>
      </div>
      <div class="provider-card">
        <div class="provider-name">Safaricom (M-Pesa)</div>
        <div class="provider-role">Processes fee payments made through M-Pesa integration</div>
      </div>
      <div class="provider-card">
        <div class="provider-name">SMS Providers</div>
        <div class="provider-role">Deliver automated SMS notifications to parents and staff</div>
      </div>
    </div>

    <p>We do not sell, rent or trade your personal data to any third party for their own marketing purposes.</p>
  </section>

  <section>
    <div class="section-number">06</div>
    <h2>Data Storage and Security</h2>
    <p>We take the security of your data seriously and implement appropriate technical and organisational measures to protect it.</p>
    <ul>
      <li>All data is transmitted over encrypted HTTPS connections</li>
      <li>Our servers are hosted on DigitalOcean with SSL certificates</li>
      <li>Access to our systems is protected by strong passwords and two-factor authentication</li>
      <li>WhatsApp conversation data is stored in access-controlled Google Sheets</li>
      <li>School data within LSMIS is protected by role-based access controls</li>
      <li>We regularly update our systems to patch security vulnerabilities</li>
    </ul>
    <p>Despite our efforts, no method of transmission over the internet is 100% secure. We encourage you to contact us immediately if you suspect any unauthorised access to your data.</p>
  </section>

  <section>
    <div class="section-number">07</div>
    <h2>Data Retention</h2>
    <p>We retain your data only for as long as necessary to provide our services or as required by law.</p>
    <ul>
      <li><strong>WhatsApp conversation data</strong> — retained for 12 months after your last interaction, then deleted</li>
      <li><strong>School management data</strong> — retained for the duration of your subscription plus 24 months, then deleted on request</li>
      <li><strong>Financial records</strong> — retained for 7 years as required by Kenyan tax regulations</li>
      <li><strong>Not Interested contacts</strong> — retained for 6 months then permanently deleted</li>
    </ul>
  </section>

  <section>
    <div class="section-number">08</div>
    <h2>Your Rights</h2>
    <p>You have the following rights regarding your personal data:</p>
    <div class="rights-grid">
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Access</strong> — Request a copy of the data we hold about you</div>
      </div>
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Correction</strong> — Request correction of inaccurate data</div>
      </div>
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Deletion</strong> — Request deletion of your personal data</div>
      </div>
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Opt-out</strong> — Stop receiving communications at any time</div>
      </div>
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Portability</strong> — Request your data in a portable format</div>
      </div>
      <div class="right-item">
        <div class="right-dot"></div>
        <div class="right-text"><strong>Objection</strong> — Object to processing of your data</div>
      </div>
    </div>

    <div class="stop-note">
      <strong>To opt out of WhatsApp messages:</strong> Simply reply <strong>STOP</strong> to any message from our WhatsApp Business number and we will immediately stop all further communication. You can also say "not interested" or "remove me" and our system will automatically stop contacting you.
    </div>
  </section>

  <section>
    <div class="section-number">09</div>
    <h2>WhatsApp Business Messaging</h2>
    <p>Our WhatsApp AI assistant <strong>Gloria</strong> operates as follows:</p>
    <ul>
      <li>All conversations are <strong>initiated by you</strong> — we never send unsolicited first messages</li>
      <li>Gloria is powered by Anthropic's Claude AI which processes your message to generate a response</li>
      <li>Your conversation history is stored to provide context-aware responses across sessions</li>
      <li>If you request to speak to a human, our team will take over the conversation and the AI will be paused</li>
      <li>Follow-up messages are sent a maximum of 3 times to clients who have previously engaged with us</li>
      <li>Clients who express disinterest are permanently removed from follow-up and never contacted again</li>
      <li>We use Meta's WhatsApp Cloud API — this service is governed by Meta's own privacy policy</li>
    </ul>
  </section>

  <section>
    <div class="section-number">10</div>
    <h2>Children's Privacy</h2>
    <p>The Ladybird School Management System processes student data on behalf of schools. This data is processed under the direction and responsibility of the school as the data controller. We act as a data processor for student information.</p>
    <p>Schools using LSMIS are responsible for obtaining appropriate consent from parents or guardians for the processing of student data in accordance with Kenyan law.</p>
    <p>Our WhatsApp Business messaging service is intended for school administrators and decision-makers only, not for direct use by students or minors.</p>
  </section>

  <section>
    <div class="section-number">11</div>
    <h2>International Data Transfers</h2>
    <p>Your data may be processed outside Kenya by our service providers including Anthropic (USA), Google (USA) and DigitalOcean (UK). We ensure appropriate safeguards are in place for such transfers in accordance with applicable data protection standards.</p>
  </section>

  <section>
    <div class="section-number">12</div>
    <h2>Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. The latest version will always be available at <strong>https://ladybirdsmis.com/privacy-policy.php</strong>.</p>
    <p>We will notify active clients of significant changes via email or WhatsApp message. Your continued use of our services after any changes constitutes acceptance of the updated policy.</p>
  </section>

  <section>
    <div class="section-number">13</div>
    <h2>Contact Us</h2>
    <p>If you have any questions, concerns or requests regarding this Privacy Policy or your personal data, please contact us through any of the channels below:</p>
    <div class="contact-box">
      <h3>Get in Touch</h3>
      <div class="contact-grid">
        <div class="contact-item">
          <span class="contact-label">Company</span>
          <span class="contact-value">Ladybird Softech Co.</span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Email</span>
          <span class="contact-value"><a href="mailto:mail@ladybirdsmis.com">mail@ladybirdsmis.com</a></span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Phone / WhatsApp</span>
          <span class="contact-value"><a href="tel:+254743551250">+254 743 551250</a></span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Website</span>
          <span class="contact-value"><a href="https://ladybirdsmis.com" target="_blank">ladybirdsmis.com</a></span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Address</span>
          <span class="contact-value">Thika, Kiambu, Kenya</span>
        </div>
        <div class="contact-item">
          <span class="contact-label">Response Time</span>
          <span class="contact-value">Within 2 business days</span>
        </div>
      </div>
    </div>
  </section>

</div>

<footer>
  <p>&copy; 2026 Ladybird Softech Co. All rights reserved. &nbsp;|&nbsp; https://ladybirdsmis.com/privacy-policy.php</p>
</footer>

</body>
</html>