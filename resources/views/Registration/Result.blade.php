<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Ticket</title>
  <style>
    /* 1. Color Palette for Light Mode */
    :root {
      --orange-wheel: #FF810D;
      --orange-peel: #FE9D18;
      --electric-purple: #BD1FFE;
      --electric-purple-2: #BA22FF;
      --text-dark: #1A1A1A;
      --ticket-bg: #ffffff;
      --ticket-border: #e0e0e0;
      --accent-gray: #777;
      --page-bg-gradient: linear-gradient(135deg, #f9f9ff, #f5f7ff, #fff8f3);
    }

    /* 2. Basic Body & Layout Setup */
    body {
      margin: 0;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      background: var(--page-bg-gradient);
      color: var(--text-dark);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 2rem;
      box-sizing: border-box;
    }

    .ticket-container {
      width: 100%;
      max-width: 380px;
      text-align: center;
    }

    /* 3. Ticket Styling */
    .ticket {
      background: var(--ticket-bg);
      border-radius: 16px;
      padding: 2rem;
      position: relative;
      border: 1px solid var(--ticket-border);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    /* Semi-circle notches */
    .ticket::before,
    .ticket::after {
      content: '';
      position: absolute;
      width: 32px;
      height: 32px;
      background: var(--page-bg-gradient);
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
    }

    .ticket::before {
      left: -16px;
    }

    .ticket::after {
      right: -16px;
    }

    /* 4. Ticket Header */
    .ticket-header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: bold;
      background: linear-gradient(90deg, var(--electric-purple), var(--orange-wheel));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .ticket-header p {
      margin: 0.25rem 0 0;
      font-size: 1rem;
      color: var(--accent-gray);
    }

    /* 5. QR Code */
    .qr-code {
      background-color: #ffffff;
      border: 1px solid #ddd;
      padding: 1rem;
      border-radius: 8px;
      margin: 2rem auto;
      max-width: 150px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .qr-code img {
      width: 100%;
      display: block;
    }

    /* 6. Divider */
    .ticket-divider {
      height: 2px;
      background: repeating-linear-gradient(90deg,
                  #ccc,
                  #ccc 10px,
                  transparent 10px,
                  transparent 20px);
      margin: 0 -2rem;
    }

    /* 7. Ticket Info */
    .ticket-info {
      padding-top: 1.5rem;
      text-align: left;
      display: flex;
      justify-content: space-between;
    }

    .ticket-info .item {
      display: flex;
      flex-direction: column;
    }

    .ticket-info .label {
      font-size: 0.8rem;
      color: var(--accent-gray);
    }

    .ticket-info .value {
      font-size: 1rem;
      font-weight: 700;
      color: var(--text-dark);
    }

    /* 8. Buttons */
    .button-group {
      margin-top: 2rem;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .download-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.9rem 1rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-decoration: none;
    }

    .download-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .btn-pdf {
      background: linear-gradient(90deg, var(--electric-purple-2), var(--electric-purple));
    }

    .btn-png {
      background: linear-gradient(90deg, var(--orange-peel), var(--orange-wheel));
    }

    .download-btn svg {
      width: 20px;
      height: 20px;
    }
  </style>
</head>
<body>

  <div class="ticket-container">
    <div class="ticket">
      <div class="ticket-header">
        <h1>Futurepreneur</h1>
        <p>Conference Pass 2025</p>
      </div>
      
      <div class="qr-code">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example" alt="QR Code">
      </div>

      <div class="ticket-divider"></div>

      <div class="ticket-info">
        <div class="item">
          <span class="label">Name</span>
          <span class="value">Alex Doe</span>
        </div>
        <div class="item" style="text-align: right;">
          <span class="label">Date</span>
          <span class="value">28 OCT 2025</span>
        </div>
      </div>
    </div>

    <div class="button-group">
      <a href="#" class="download-btn btn-pdf">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        <span>PDF</span>
      </a>
      <a href="#" class="download-btn btn-png">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        <span>PNG</span>
      </a>
    </div>
  </div>

</body>
</html>
