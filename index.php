<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mining Calculator (UI Mock)</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" />

  <style>
    :root{
      --bg:#05070a;

      /* glass (your snippet) */
      --panel: rgba(124, 37, 239, 0.10);
      --panel-border: rgba(124, 37, 239, 0.30);
      --shadow: 0 4px 30px rgba(0,0,0,0.10);
      --blur: blur(4.7px);

      --text:#e9eef6;
      --muted:#98a3b7;

      --accent:#b8ff00; /* neon green */
      --lime:#B8FE08; /* infographic lime */
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      position:relative;
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif;
      color:var(--text);
      background:
        radial-gradient(1200px 700px at 50% -10%, rgba(124,37,239,.25), transparent 55%),
        radial-gradient(900px 600px at 80% 70%, rgba(184,255,0,.12), transparent 60%),
        linear-gradient(180deg, #030508 0%, #05070a 45%, #04060a 100%);
      overflow-x:hidden;
    }

    /* dotted pattern */
    body::before{
      content:"";
      position:fixed;
      z-index:1;
      inset:0;
      pointer-events:none;
      background: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.08) 1px, transparent 1.6px);
      background-size: 28px 28px;
      opacity:.35;
      mask-image: radial-gradient(closest-side, rgba(0,0,0,.9), rgba(0,0,0,.15));
    }

    /* ===== 3D cubes background (fused) ===== */
    .bg-3d{
      position: fixed;
      inset: 0;
      z-index: 0;
      pointer-events: none;
      perspective: 900px;
      overflow: hidden;
    }

    .bg-3d::before{
      content:"";
      position:absolute;
      inset:0;
      background:
        radial-gradient(900px 600px at 20% 10%, rgba(124,37,239,0.16), transparent 60%),
        radial-gradient(700px 500px at 80% 80%, rgba(184,255,0,0.10), transparent 55%),
        radial-gradient(900px 900px at 50% 50%, rgba(255,255,255,0.04), transparent 65%);
    }

    .scene{
      position:absolute;
      inset:0;
      transform-style: preserve-3d;
    }

    .cube{
      position:absolute;
      left:0;
      top:0;
      width: var(--s);
      height: var(--s);
      transform-style: preserve-3d;
      transform:
        translate3d(var(--x), var(--y), var(--z))
        rotateX(var(--rx))
        rotateY(var(--ry))
        rotateZ(var(--rz));
      animation: spin var(--dur) linear infinite;
      opacity: 0.9;
      will-change: transform;
    }

    @keyframes spin{
      from{
        transform:
          translate3d(var(--x), var(--y), var(--z))
          rotateX(var(--rx))
          rotateY(var(--ry))
          rotateZ(var(--rz));
      }
      to{
        transform:
          translate3d(var(--x), var(--y), var(--z))
          rotateX(calc(var(--rx) + 360deg))
          rotateY(calc(var(--ry) + 360deg))
          rotateZ(calc(var(--rz) + 180deg));
      }
    }

    .face{
      position:absolute;
      inset:0;
      border-radius: 10px;
      backface-visibility: hidden;
      background:
        linear-gradient(135deg, rgba(255,255,255,0.20), rgba(255,255,255,0.03)),
        hsla(var(--h), 85%, 62%, var(--a));
      border: 1px solid rgba(255,255,255,0.20);
      box-shadow:
        0 0 22px rgba(255,255,255,0.05),
        inset 0 0 18px rgba(0,0,0,0.35);
    }

    .front  { transform: translateZ(calc(var(--s) / 2)); }
    .back   { transform: rotateY(180deg) translateZ(calc(var(--s) / 2)); }
    .right  { transform: rotateY(90deg)  translateZ(calc(var(--s) / 2)); }
    .left   { transform: rotateY(-90deg) translateZ(calc(var(--s) / 2)); }
    .top    { transform: rotateX(90deg)  translateZ(calc(var(--s) / 2)); }
    .bottom { transform: rotateX(-90deg) translateZ(calc(var(--s) / 2)); }

    @media (prefers-reduced-motion: reduce){
      .cube{ animation: none; }
    }

    .wrap{
      position:relative;
      z-index:2;
      max-width: 1480px;
      margin: 0 auto;
      padding: 48px 20px 60px;
    }

    .title{
      font-weight: 800;
      letter-spacing: .3px;
      font-size: clamp(42px, 5vw, 64px);
      margin: 0 0 28px;
      line-height:1.05;
    }
    .title .accent{ color: var(--accent); }

    .layout{
      display:grid;
      grid-template-columns: 300px 1fr 300px;
      gap: 20px;
      align-items:start;
    }

    /* glass card (your css.glass) */
    .glass{
      background: var(--panel);
      border-radius: 16px;
      box-shadow: var(--shadow);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      border: 1px solid var(--panel-border);
    }

    .side{
      padding: 18px;
      position:relative;
      overflow:visible; /* IMPORTANT for dropdown */
    }

    .label{
      font-size: 18px;
      margin: 12px 0 12px;
      color: var(--text);
      font-weight: 650;
    }

    .centerTitle{
      text-align:center;
      font-weight: 750;
      font-size: 20px;
      margin: 6px 0 14px;
    }

    .field{
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      border-radius: 12px;
      padding: 12px 12px;
    }

    .row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 10px;
    }

    .amountInput{
      width:100%;
      border:0;
      background: transparent;
      color: var(--text);
      font-weight: 700;
      font-size: 16px;
      outline: none;
    }
    .suffix{
      color: var(--muted);
      font-weight: 800;
      font-size: 13px;
      margin-left: 8px;
      white-space:nowrap;
    }

    /* range slider styling */
    input[type="range"]{
      width:100%;
      margin: 14px 0 2px;
      -webkit-appearance:none;
      appearance:none;
      height: 8px;
      border-radius: 999px;
      background: linear-gradient(90deg, var(--accent) 0%, rgba(184,255,0,.25) 60%, rgba(255,255,255,.12) 100%);
      outline:none;
    }
    input[type="range"]::-webkit-slider-thumb{
      -webkit-appearance:none;
      appearance:none;
      width: 22px; height: 22px;
      border-radius:50%;
      background: var(--accent);
      box-shadow: 0 0 0 6px rgba(184,255,0,.18);
      border: 2px solid rgba(0,0,0,.35);
      cursor:pointer;
    }
    input[type="range"]::-moz-range-thumb{
      width: 22px; height: 22px;
      border-radius:50%;
      background: var(--accent);
      border: 2px solid rgba(0,0,0,.35);
      cursor:pointer;
    }

    /* ---- Center panel ---- */
    .center{
      padding: 18px 18px 20px;
      position:relative;
      overflow:hidden;
      min-width: 0;
      isolation: isolate; /* keep background layers behind */
    }

    /* ===== Center background decor (wave like screenshot) ===== */
    .center > :not(.centerDecor){
      position: relative;
      z-index: 2;
    }

    .centerDecor{
      position:absolute;
      inset:0;
      z-index: 0;
      pointer-events:none;
    }

    .centerGlow{
      position:absolute;
      inset:-50px -90px auto -90px;
      height: 240px;
      background: radial-gradient(closest-side, rgba(184,255,0,0.10), transparent 70%);
      opacity: .9;
      filter: blur(2px);
    }

    .centerWave{
      position:absolute;
      left:-15%;
      width: 130%;
      bottom:-26px;
      height: 58%;
      filter: drop-shadow(0 -18px 40px rgba(184,255,0,0.18));
      opacity: 1;
    }

    .centerWave .waveFill{ opacity: .55; }
    .centerWave .waveStripes{ opacity: .14; }
    .centerWave .waveLine{ opacity: .9; }

    /* subtle inner border so it looks more like a panel */
    .center{
      box-shadow: 0 18px 60px rgba(0,0,0,0.28);
    }

    .twoBoxes{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-top: 12px;
    }

    .miniBox{
      padding: 14px 14px;
      border-radius: 12px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      min-height: 66px;
      display:flex;
      align-items:center;
      justify-content:space-between;
    }
    .miniBox .k{ color: var(--muted); font-size: 13px; font-weight: 650; }
    .miniBox .v{ font-size: 22px; font-weight: 850; color: var(--accent); }

    .profits{
      display:grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
      margin-top: 12px;
      align-items:stretch;
    }

    .profitCard{
      padding: 14px 14px 12px;
      border-radius: 12px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      min-height: 88px;
    }
    .profitCard .k{
      font-size: 13px;
      color: var(--muted);
      font-weight: 650;
      margin-bottom: 8px;
    }
    .profitCard .big{
      font-weight: 850;
      color: var(--accent);
      font-size: 17px;
      letter-spacing: .1px;
      line-height: 1.15;
      min-width: 0;
      overflow-wrap: anywhere;
      word-break: break-word;
    }
    .profitCard .usd{
      margin-top: 4px;
      color: rgba(184,255,0,.65);
      font-weight: 750;
      font-size: 13px;
    }

    .bottomRow{
      display:grid;
      grid-template-columns: 1fr 1fr 220px;
      gap: 12px;
      margin-top: 12px;
      align-items:stretch;
    }

    .cta{
      border-radius: 12px;
      background: linear-gradient(180deg, rgba(184,255,0,.95), rgba(156,255,0,.85));
      border: 1px solid rgba(184,255,0,.55);
      color:#081100;
      font-weight: 900;
      font-size: 18px;
      display:grid;
      place-items:center;
      cursor:pointer;
      user-select:none;
    }
    .cta:active{ transform: translateY(1px); }

    /* little curved arrows (decor) */
    .arc{
      position:absolute;
      inset:auto auto 20px 18px;
      width: 120px;
      height: 60px;
      border: 2px solid rgba(184,255,0,.35);
      border-color: rgba(184,255,0,.35) transparent transparent transparent;
      border-radius: 140px 140px 0 0;
      transform: rotate(-10deg);
      opacity:.55;
      pointer-events:none;
    }
    .arc.right{
      left:auto;
      right: 18px;
      transform: rotate(10deg) scaleX(-1);
    }

    /* ===== Bubble profitability (segments in middle + gaps) ===== */
    .bubbleTitle{
      text-align:center;
      font-weight: 800;
      font-size: 24px;
      margin: 8px 0 12px;
      letter-spacing: .15px;
    }

    .bubbleLabels{
      display:flex;
      justify-content:space-between;
      gap: 10px;
      margin: 0 0 10px;
      padding: 0 18px;
      font-size: 12px;
      color: rgba(233,238,246,0.90);
      user-select:none;
    }
    .bubbleLabels .dim{ opacity: .35; }

    .bubbleRail{
      position:relative;
      padding: 0 18px 70px; /* space for pill */
    }

    .bubbleTrack{
      display:flex;
      align-items:center; /* line in middle of circles */
      justify-content:space-between;
      width:100%;
      position: relative;
    }

    .bubbleBtn{
      width: 18px;
      height: 18px;
      border-radius: 999px;
      border: 2px solid rgba(255,255,255,0.22);
      background: rgba(184,255,0,0.18);
      cursor:pointer;
      position:relative;
      padding:0;
      outline:none;
      flex: 0 0 auto;
    }

    .bubbleBtn.is-active{
      background: var(--accent);
      border-color: rgba(184,255,0,0.90);
      box-shadow: 0 0 0 5px rgba(184,255,0,0.16);
    }

    .bubbleBtn.is-off{
      background: transparent;
      border-color: rgba(160,170,190,0.45);
      box-shadow: none;
    }

    .bubbleBtn.is-selected::after{
      content:"✓";
      position:absolute;
      inset:0;
      display:grid;
      place-items:center;
      font-weight: 900;
      font-size: 11px;
      color: #071000;
    }

    .bubbleSeg{
      height: 5px;
      border-radius: 999px;
      background: rgba(255,255,255,0.22);
      flex: 1 1 auto;
      margin: 0 7px; /* tighter gap so it looks like a line */
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.06);
    }

    .bubbleSeg.is-active{
      background: rgba(184,255,0,0.88);
      box-shadow: 0 0 18px rgba(184,255,0,0.22);
    }

    .bubblePill{
      position:absolute;
      top: 36px;
      left: 0px;          /* JS sets it */
      transform: translateX(-50%);
      padding: 8px 14px;
      border-radius: 12px;
      background: rgba(184,255,0,0.95);
      border: 1px solid rgba(184,255,0,0.55);
      color: #081100;
      font-weight: 900;
      font-size: 13px;
      box-shadow: 0 16px 30px rgba(0,0,0,0.35);
      user-select:none;
      white-space:nowrap;
    }

    /* ===== Shared dropdown look (Investment + Mining) ===== */
    .ddWrap{ position:relative; margin-top: 8px; }
    .ddWrap.open .ddMenu{ display:block; }
    .ddWrap.open .ddChevron{ transform: rotate(-135deg); }

    .ddBtn{
      width:100%;
      border:0;
      padding: 14px 14px;
      border-radius: 14px;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
    }

    .ddLeft{
      display:flex;
      align-items:center;
      gap: 12px;
      min-width: 0;
    }

    .ddIcon{
      width: 40px;
      height: 40px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      font-weight: 900;
      font-size: 18px;
      color:#fff;
      flex:0 0 auto;
      position:relative;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
    }

    .ddIcon svg, .ddIcon .coinImg{ width: 22px; height: 22px; display:block; }

    .ddBadge{
      position:absolute;
      right: -3px;
      bottom: -3px;
      width: 18px;
      height: 18px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      font-weight: 900;
      font-size: 10px;
      color:#fff;
      border: 2px solid rgba(0,0,0,0.35);
    }

    .ddName{
      font-weight: 800;
      font-size: 16px;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
    }

    /* dropdown selected labels */
    #mcName{ color:#fff; }
    #icName{ color:#fff; }

    .ddTicker{
      font-weight: 900;
      color: var(--accent);
      letter-spacing: .3px;
      margin-left:auto;
    }

    .ddChevron{
      width: 10px;
      height: 10px;
      border-right: 2px solid var(--accent);
      border-bottom: 2px solid var(--accent);
      transform: rotate(45deg);
      transition: transform .15s ease;
      margin-left: 8px;
      flex: 0 0 auto;
    }

    .ddMenu{
      display:none;
      position:absolute;
      top: calc(100% + 8px);
      left:0;
      right:0;
      border-radius: 14px;
      overflow:hidden;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      z-index: 50;
      max-height: 520px;
      overflow:auto;
    }

    /* scrollbar */
    .ddMenu::-webkit-scrollbar{ width: 10px; }
    .ddMenu::-webkit-scrollbar-thumb{
      background: rgba(255,255,255,0.12);
      border-radius: 999px;
      border: 2px solid rgba(0,0,0,0.20);
    }

    .ddItem{
      width:100%;
      border:0;
      background: transparent;
      cursor:pointer;
      color: var(--text);
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding: 12px 14px;
    }
    .ddItem:hover{ background: rgba(255,255,255,0.06); }

    .ddItemLeft{
      display:flex;
      align-items:center;
      gap: 12px;
      min-width:0;
    }

    .ddItemIcon{
      width: 36px;
      height: 36px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      font-weight: 900;
      font-size: 16px;
      color:#fff;
      flex:0 0 auto;
      position:relative;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
    }
    .ddItemIcon svg, .ddItemIcon .coinImg{ width: 20px; height: 20px; display:block; }

    .coinImg{
      display:block;
      filter: drop-shadow(0 8px 14px rgba(0,0,0,0.35));
    }

    .ddItemName{
      font-weight: 800;
      font-size: 15px;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
      color: rgba(233,238,246,0.72);
    }

    .ddItemTicker{
      font-weight: 900;
      color: var(--accent);
      letter-spacing:.3px;
    }

    .ddItem.is-selected{
      background: rgba(184,255,0,0.92);
      color: #071000;
    }
    .ddItem.is-selected .ddItemName{ color:#071000; }
    .ddItem.is-selected .ddItemTicker{ color:#071000; }

    /* icon colors */
    .icon-trx{ background: radial-gradient(circle at 30% 30%, #ff3b3b, #b70000); }
    .icon-btc{ background: radial-gradient(circle at 30% 30%, #ffb44c, #ff7a00); }
    .icon-bch{ background: radial-gradient(circle at 30% 30%, #46d25a, #1b8f2a); }
    .icon-bnb{ background: radial-gradient(circle at 30% 30%, #ffd36a, #c38a00); color:#241600; }
    .icon-dash{ background: radial-gradient(circle at 30% 30%, #1aa7ff, #0068c9); }
    .icon-doge{ background: radial-gradient(circle at 30% 30%, #ffd36a, #c38a00); color:#241600; }
    .icon-xec{ background: radial-gradient(circle at 30% 30%, #1da1ff, #0068c9); }
    .icon-kas{ background: radial-gradient(circle at 30% 30%, #00d5d5, #007b7b); }
    .icon-ltc{ background: radial-gradient(circle at 30% 30%, #aeb5bf, #6f7682); }
    .icon-usdt{ background: radial-gradient(circle at 30% 30%, #22c7a5, #0a6a57); }

    .badge-bnb{ background: radial-gradient(circle at 30% 30%, #ffd36a, #c38a00); color:#241600; }
    .badge-trx{ background: radial-gradient(circle at 30% 30%, #ff3b3b, #b70000); }

    /* prevent overflow clipping (fix missing right side) */
    .center, .profits, .bottomRow, .twoBoxes{ min-width:0; }
    .profits > *, .bottomRow > *, .twoBoxes > *{ min-width:0; }
    .profitCard, .miniBox{ min-width:0; }
    .profitCard .usd{ overflow-wrap:anywhere; word-break:break-word; }

    /* responsive */
    @media (max-width: 1050px){
      .layout{ grid-template-columns: 1fr; }
      .bottomRow{ grid-template-columns: 1fr; }
      .profits{ grid-template-columns: 1fr; }
      .twoBoxes{ grid-template-columns: 1fr; }
      .arc{ display:none; }
    }

    /* tighter + centered profitability on very small screens */
    @media (max-width: 520px){
      .bubbleTitle{ font-size: 20px; margin: 6px 0 10px; }

      .bubbleLabels{
        padding: 0 10px;
        font-size: 10px;
        gap: 8px;
        justify-content:center;
        flex-wrap: wrap;
        row-gap: 6px;
      }

      .bubbleRail{ padding: 0 10px 58px; }

      .bubbleTrack{ justify-content:center; }

      .bubbleBtn{ width: 14px; height: 14px; }
      .bubbleBtn.is-active{ box-shadow: 0 0 0 4px rgba(184,255,0,0.16); }
      .bubbleBtn.is-selected::after{ font-size: 9px; }

      /* fixed small connectors so all 11 levels fit without breaking */
      .bubbleSeg{
        flex: 0 0 6px;
        height: 4px;
        margin: 0 3px;
      }

      .bubblePill{
        top: 28px;
        padding: 7px 12px;
        font-size: 12px;
      }
    }
  
    /* ===== Marketing section (like screenshot) ===== */
    .marketing{
      margin-top: 56px;
    }

    .mkTitle{
      font-weight: 900;
      letter-spacing: .2px;
      font-size: clamp(44px, 5vw, 64px);
      margin: 0 0 18px;
      line-height: 1.05;
    }

    .mkGrid{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
      align-items:stretch;
    }

    .mkCard{
      overflow:hidden;
      border-radius: 18px;
    }

    .mkHeader{
      display:flex;
      align-items:center;
      gap: 14px;
      padding: 18px 18px;
      border-bottom: 1px solid rgba(255,255,255,0.10);
      background:
        radial-gradient(900px 320px at 30% 0%, rgba(255,255,255,0.08), transparent 55%),
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
    }

    .mkIcon{
      width: 56px;
      height: 56px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      background: rgba(184,255,0,0.95);
      border: 1px solid rgba(184,255,0,0.55);
      box-shadow: 0 18px 40px rgba(0,0,0,0.35);
      flex: 0 0 auto;
      color: #071000;
      font-weight: 1000;
      font-size: 30px;
      line-height: 1;
    }

    .mkName{
      font-weight: 900;
      font-size: 28px;
      letter-spacing: .2px;
      color:#fff;
    }

    .mkBody{ padding: 12px 16px 14px; }

    .mkTable{
      width:100%;
      border-collapse: collapse;
      border-spacing: 0;
    }

    .mkTable th{
      text-align:left;
      color: var(--accent);
      font-weight: 900;
      font-size: 13px;
      padding: 0 10px;
    }

    .mkTable td{
      padding: 8px 10px;
      color:#fff;
      font-weight: 800;
      font-size: 15px;
    }

    .mkTable tbody tr{
      background: rgba(0,0,0,0.10);
    }

    .mkTable tbody tr + tr{
      border-top: 1px solid rgba(255,255,255,0.08);
    }

    .mkTable td:first-child{ text-align:left; }
    .mkTable td:last-child{ text-align:right; }

    .mkTable td:nth-child(2){
      text-align:center;
      color: #fff;
    }

    .mkTable .mkHash{ color: rgba(233,238,246,0.95); }

    @media (max-width: 1050px){
      .mkGrid{ grid-template-columns: 1fr; }
      .mkName{ font-size: 26px; }
    }

  
    /* ===== Wexon statistics section (like screenshot) ===== */
    .stats{
      margin-top: 56px;
    }

    .statsHeader{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 16px;
      margin: 0 0 18px;
    }

    .statsTitle{
      margin: 0;
      font-weight: 950;
      letter-spacing: .2px;
      font-size: clamp(40px, 4.6vw, 64px);
      line-height: 1.05;
    }

    .statsTitle .w{ color: var(--accent); }
    .statsTitle .s{ color: rgba(233,238,246,0.70); font-weight: 900; }

    .growCallout{
      display:flex;
      align-items:center;
      gap: 14px;
      padding: 10px 14px 10px 10px;
      border-radius: 18px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      user-select:none;
      white-space:nowrap;
    }

    .growIcon{
      width: 54px;
      height: 54px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      background: rgba(184,255,0,0.95);
      border: 1px solid rgba(184,255,0,0.55);
      color: #071000;
      flex: 0 0 auto;
      box-shadow: 0 18px 40px rgba(0,0,0,0.35);
    }

    .growText{
      font-weight: 900;
      font-size: 22px;
      letter-spacing: .2px;
      color:#fff;
    }

    .statsGrid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 18px;
      align-items:stretch;
    }

    .statCard{
      position:relative;
      overflow:hidden;
      border-radius: 18px;
      padding: 14px 16px 14px;
      min-height: 130px;
      box-shadow: 0 18px 60px rgba(0,0,0,0.28);
    }

    .statCard::before{
      content:"";
      position:absolute;
      inset:0;
      background:
        radial-gradient(600px 220px at 30% 0%, rgba(255,255,255,0.08), transparent 55%),
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(0,0,0,0.00));
      opacity: .95;
      pointer-events:none;
    }

    .statCard > *{ position:relative; z-index: 1; }

    .statTop{
      display:flex;
      align-items:center;
      gap: 10px;
      color:#fff;
      font-weight: 900;
      font-size: 15px;
      letter-spacing: .2px;
    }

    .statIcon{
      width: 22px;
      height: 22px;
      display:grid;
      place-items:center;
      color: var(--accent);
      flex: 0 0 auto;
    }

    .statIcon svg{ width: 22px; height: 22px; display:block; }
    .statIcon img{ width: 22px; height: 22px; display:block; filter: drop-shadow(0 10px 18px rgba(0,0,0,0.35)); }
    .growIcon img{ width: 28px; height: 28px; display:block; }

    .statValue{
      margin-top: 14px;
      font-weight: 1000;
      font-size: clamp(44px, 4vw, 68px);
      letter-spacing: .6px;
      line-height: 1;
      color:#fff;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:nowrap;
    }

    .statValueMd{
      font-size: clamp(34px, 3vw, 54px);
      letter-spacing: .3px;
    }

    .statUnit{
      margin-top: 2px;
      font-weight: 950;
      font-size: 16px;
      color:#fff;
      opacity: .95;
      text-transform: lowercase;
    }

    .statSub{
      margin-top: 4px;
      font-weight: 950;
      font-size: 18px;
      color: var(--accent);
      letter-spacing: .2px;
    }

    @media (max-width: 1050px){
      .statsGrid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .growText{ font-size: 18px; }
      .growIcon{ width: 48px; height: 48px; }
    }

    @media (max-width: 520px){
      .statsHeader{ align-items:flex-start; flex-direction:column; }
      .growCallout{ width: 100%; justify-content:space-between; }
      .statsGrid{ grid-template-columns: 1fr; }
      .statValue{ font-size: 56px; }
    }

  
    /* ===== Latest deposits/withdrawals (like screenshot) ===== */
    .latest{
      margin-top: 56px;
    }

    .latestGrid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 22px;
      align-items:start;
    }

    .latestTitle{
      margin: 0 0 14px;
      font-weight: 950;
      letter-spacing: .2px;
      font-size: clamp(34px, 4vw, 56px);
      color: rgba(233,238,246,0.80);
      line-height: 1.05;
    }

    .latestCard{
      overflow:hidden;
      border-radius: 18px;
      padding: 0;
    }

    .latestTable{
      width: 100%;
      border-collapse: collapse;
    }

    .latestTable thead th{
      text-align:left;
      color: var(--accent);
      font-weight: 950;
      font-size: 14px;
      padding: 16px 18px;
      background:
        radial-gradient(900px 280px at 30% 0%, rgba(255,255,255,0.08), transparent 55%),
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    .latestTable td{
      padding: 14px 18px;
      color: #fff;
      font-weight: 850;
      font-size: 15px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    .latestTable tbody tr:nth-child(odd){
      background: rgba(255,255,255,0.02);
    }

    .latestTable tbody tr:nth-child(even){
      background: rgba(0,0,0,0.10);
    }

    .latestTable tbody tr:hover{
      background: rgba(184,255,0,0.06);
    }

    .latestTable td:nth-child(2), .latestTable th:nth-child(2){
      text-align:center;
    }

    .latestTable td:nth-child(3), .latestTable th:nth-child(3){
      text-align:right;
      white-space:nowrap;
    }

    .latestUser{
      font-weight: 900;
      letter-spacing: .1px;
    }

    .latestAmount{
      font-weight: 950;
    }

    @media (max-width: 1050px){
      .latestGrid{ grid-template-columns: 1fr; }
    }

  
    /* ===== Client testimonials ===== */
    .testimonials{
      margin-top: 56px;
    }

    .testimonialsHeader{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap: 16px;
      margin: 0 0 18px;
    }

    .testimonialControls{
      display:flex;
      gap: 10px;
    }

    .testimonialBtn{
      width: 46px;
      height: 46px;
      border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.12);
      background: rgba(255,255,255,0.06);
      color: var(--accent);
      display:grid;
      place-items:center;
      cursor:pointer;
      box-shadow: 0 14px 30px rgba(0,0,0,0.25);
    }

    .testimonialBtn:active{ transform: translateY(1px); }

    .testimonialGrid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 16px;
      padding: 24px;
    }

    .testimonialCard{
      height:100%;
      padding: 24px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      gap: 18px;
    }

    .testimonialStars{
      display:flex;
      gap: 6px;
      color: var(--accent);
      font-size: 16px;
    }

    .testimonialQuote{
      font-size: 18px;
      line-height: 1.6;
      color: rgba(233,238,246,0.90);
      margin: 0;
    }

    .testimonialPerson{
      display:flex;
      align-items:center;
      gap: 14px;
    }

    .testimonialAvatar{
      width: 56px;
      height: 56px;
      border-radius: 999px;
      object-fit: cover;
      border: 2px solid rgba(184,255,0,0.70);
      box-shadow: 0 12px 26px rgba(0,0,0,0.35);
    }

    .testimonialName{
      font-weight: 900;
      font-size: 16px;
      color: #fff;
    }

    .testimonialRole{
      color: rgba(233,238,246,0.65);
      font-weight: 700;
      font-size: 13px;
      margin-top: 2px;
    }

    @media (max-width: 1050px){
      .testimonialsHeader{ align-items:flex-start; flex-direction:column; }
      .testimonialGrid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 520px){
      .testimonialQuote{ font-size: 16px; }
      .testimonialBtn{ width: 42px; height: 42px; }
      .testimonialGrid{ grid-template-columns: 1fr; }
    }

  
    /* ===== Affiliate infographic (flat 2D) ===== */
    .affiliate{ margin-top: 64px; }

    .affTopBar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 16px;
      margin: 0 0 18px;
    }

    .affGrid{
      display:grid;
      grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.35fr);
      gap: 34px;
      align-items:center;
    }

    .affLeft{
      position:relative;
      overflow:hidden;
      border-radius: 20px;
      padding: 18px;
      background: rgba(8,10,14,0.58);
      border: 1px solid rgba(184,254,8,0.10);
      box-shadow: 0 24px 80px rgba(0,0,0,0.45);
      isolation: isolate;
    }

    .affLeft::before{
      content:"";
      position:absolute;
      inset:0;
      z-index:0;
      background: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.10) 1px, transparent 1.7px);
      background-size: 26px 26px;
      opacity: .18;
      pointer-events:none;
    }

    .affLeft::after{
      content:"";
      position:absolute;
      inset:-2px;
      z-index:1;
      background: radial-gradient(closest-side, rgba(0,0,0,0.00) 35%, rgba(0,0,0,0.62) 100%);
      pointer-events:none;
    }

    .affLeft > *{ position:relative; z-index: 2; }

    .affGraph{
      position:relative;
      aspect-ratio: 16 / 10;
      min-height: 340px;
    }

    .affCanvas{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      pointer-events:none;
    }

    .affStep{
      position:absolute;
      display:flex;
      flex-direction:column;
      gap: 10px;
      max-width: 240px;
    }

    .affStepBadge{
      width: 88px;
      height: 88px;
      border-radius: 24px;
      background: var(--lime);
      border: 1px solid rgba(184,254,8,0.55);
      display:grid;
      place-items:center;
      color:#071000;
      font-weight: 1000;
      font-size: 34px;
      letter-spacing: .2px;
      box-shadow:
        0 22px 50px rgba(0,0,0,0.45),
        0 0 26px rgba(184,254,8,0.18);
      position:relative;
      overflow:hidden;
    }

    .affStepBadge span{
      font-size: 12px;
      font-weight: 900;
      letter-spacing: .3px;
      text-transform: uppercase;
      color: rgba(7,16,0,0.75);
      position:absolute;
      bottom: 12px;
    }

    .affStep.s1{ left: 14%; top: 58%; }
    .affStep.s2{ left: 47%; top: 40%; }
    .affStep.s3{ left: 78%; top: 18%; }

    .affMeta{
      color: rgba(233,238,246,0.72);
      font-weight: 750;
      font-size: 15px;
      line-height: 1.35;
      text-shadow: 0 10px 24px rgba(0,0,0,0.35);
    }

    .affMeta .lvl{
      color:#fff;
      font-weight: 900;
      font-size: 16px;
      margin-bottom: 6px;
    }

    .affRight{ min-width: 0; }

    .affTitle{
      margin: 0 0 14px;
      font-weight: 1000;
      letter-spacing: .2px;
      font-size: clamp(42px, 5vw, 72px);
      line-height: 1.02;
      color:#fff;
    }

    .affTitle .acc{ color: var(--accent); }

    .affText{
      margin: 0;
      color: rgba(233,238,246,0.72);
      font-weight: 750;
      font-size: 16px;
      line-height: 1.55;
      max-width: 720px;
    }

    .affText + .affText{ margin-top: 14px; }

    .affBtn{
      margin-top: 22px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap: 10px;
      padding: 16px 34px;
      border-radius: 999px;
      border: 1px solid rgba(184,255,0,0.55);
      background: rgba(184,255,0,0.95);
      color:#071000;
      font-weight: 1000;
      font-size: 18px;
      cursor:pointer;
      user-select:none;
      box-shadow: 0 22px 50px rgba(0,0,0,0.45);
    }

    .affBtn:active{ transform: translateY(1px); }

    @media (max-width: 1050px){
      .affGrid{ grid-template-columns: 1fr; }
    }

    @media (max-width: 520px){
      .affLeft{ padding: 14px; }
      .affStepBadge{ width: 78px; height: 78px; border-radius: 24px; font-size: 30px; }
      .affMeta{ font-size: 14px; }
      .affMeta .lvl{ font-size: 15px; }
      .affStep.s2{ left: 34%; }
      .affStep.s3{ left: 64%; }
    }

    /* ===== Footer ===== */
    .site-footer{
      margin: 72px 0 20px;
      padding: 30px 32px;
      display:flex;
      flex-direction:column;
      gap: 22px;
    }

    .footer-grid{
      display:grid;
      grid-template-columns: 2.2fr repeat(3, 1fr) 1.2fr;
      gap: 26px;
    }

    .footer-brand{
      max-width: 360px;
      display:flex;
      flex-direction:column;
      gap: 14px;
    }

    .footer-title{
      font-weight: 900;
      font-size: 20px;
      letter-spacing: .2px;
    }

    .footer-copy{
      color: rgba(233,238,246,0.65);
      font-weight: 650;
      line-height: 1.6;
      margin: 0;
    }

    .footer-icons{
      display:flex;
      align-items:center;
      gap: 10px;
    }

    .footer-icon{
      width: 38px;
      height: 38px;
      border-radius: 999px;
      display:grid;
      place-items:center;
      color: #0b1c2a;
      background: linear-gradient(135deg, #4aa8ff, #29c4ff);
      border: 1px solid rgba(255,255,255,0.2);
      text-decoration:none;
      transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    }

    .footer-icon:nth-child(2){ background: linear-gradient(135deg, #38d2ff, #2b95ff); }
    .footer-icon:nth-child(3){ background: linear-gradient(135deg, #3b7bff, #2851ff); }
    .footer-icon:nth-child(4){ background: linear-gradient(135deg, #3fa6ff, #1da1ff); }

    .footer-icon:hover{
      transform: translateY(-2px);
      border-color: rgba(184,255,0,0.6);
      box-shadow: 0 12px 26px rgba(0,0,0,0.35);
      color: #071000;
    }

    .footer-heading{
      font-weight: 800;
      font-size: 16px;
      margin: 0 0 10px;
      letter-spacing: .2px;
    }

    .footer-links{
      display:flex;
      flex-direction:column;
      gap: 8px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .footer-links a{
      color: rgba(233,238,246,0.7);
      text-decoration:none;
      font-weight: 650;
    }

    .footer-links a:hover{ color: var(--accent); }

    .footer-apps{
      display:flex;
      flex-direction:column;
      gap: 12px;
    }

    .footer-app-btn{
      display:flex;
      align-items:center;
      justify-content:center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.16);
      background: rgba(255,255,255,0.06);
      color: var(--text);
      font-weight: 700;
      text-decoration:none;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
      transition: transform .15s ease, border-color .15s ease;
    }

    .footer-app-btn i{
      font-size: 16px;
    }

    .footer-app-btn:hover{
      transform: translateY(-1px);
      border-color: rgba(184,255,0,0.55);
    }

    .footer-bottom{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 16px;
      flex-wrap: wrap;
      color: rgba(233,238,246,0.6);
      font-weight: 650;
      font-size: 14px;
    }

    @media (max-width: 1100px){
      .footer-grid{
        grid-template-columns: 1.6fr 1fr 1fr;
        row-gap: 22px;
      }

      .footer-grid .footer-column.app-col{
        grid-column: 1 / -1;
      }
    }

    @media (max-width: 720px){
      .footer-grid{
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 520px){
      .site-footer{ padding: 22px 20px; }
      .footer-bottom{ flex-direction:column; align-items:flex-start; }
    }

  
    /* ===== Hero (top) ===== */
    .hero{
      margin: 0 0 46px;
      padding-top: 6px;
    }

    .heroNav{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 16px;
      padding: 10px 6px;
    }

    .brand{
      display:flex;
      align-items:center;
      gap: 10px;
      font-weight: 1000;
      letter-spacing: .2px;
      color:#fff;
      user-select:none;
    }

    .brandMark{
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.14);
      display:grid;
      place-items:center;
      box-shadow: 0 18px 50px rgba(0,0,0,0.35);
    }

    .brandMark span{
      display:block;
      width: 22px;
      height: 22px;
      border-radius: 6px;
      background: linear-gradient(180deg, rgba(184,255,0,0.95), rgba(184,255,0,0.45));
      transform: rotate(12deg);
      box-shadow: 0 0 0 4px rgba(184,255,0,0.10);
    }

    .brandName{
      font-size: 24px;
      line-height: 1;
    }

    .heroLinks{
      display:flex;
      align-items:center;
      justify-content:center;
      gap: 14px;
      flex: 1 1 auto;
      min-width: 0;
      color: rgba(233,238,246,0.78);
      font-weight: 750;
      font-size: 14px;
      white-space:nowrap;
      overflow:auto;
      scrollbar-width: none;
    }
    .heroLinks::-webkit-scrollbar{ display:none; }

    .heroLinks a{
      color: inherit;
      text-decoration:none;
      padding: 8px 10px;
      border-radius: 12px;
    }
    .heroLinks a:hover{ background: rgba(255,255,255,0.04); color:#fff; }

    .heroRightNav{
      display:flex;
      align-items:center;
      gap: 10px;
      flex: 0 0 auto;
    }

    .langPill{
      display:flex;
      align-items:center;
      gap: 8px;
      padding: 9px 11px;
      border-radius: 999px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.10);
      color: rgba(233,238,246,0.85);
      font-weight: 850;
      font-size: 14px;
    }

    .pillBtn{
      padding: 10px 16px;
      border-radius: 999px;
      border: 1px solid rgba(184,255,0,0.55);
      background: rgba(184,255,0,0.95);
      color: #071000;
      font-weight: 1000;
      font-size: 14px;
      cursor:pointer;
      user-select:none;
      box-shadow: 0 20px 45px rgba(0,0,0,0.35);
      white-space:nowrap;
    }

    .pillBtn.ghost{
      background: rgba(184,255,0,0.14);
      color: rgba(233,238,246,0.92);
      border-color: rgba(255,255,255,0.16);
      box-shadow:none;
    }

    .heroMain{
      display:grid;
      grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
      gap: 34px;
      align-items:start;
      margin-top: 24px;
    }

    .heroLeft{
      margin-left: clamp(20px, 6vw, 80px);
      max-width: 680px;
    }

    .heroKicker{
      font-weight: 900;
      font-size: 18px;
      color: rgba(233,238,246,0.88);
      margin-bottom: 14px;
    }

    .heroKicker .acc{ color: var(--accent); }

    .heroHeadline{
      margin: 0 0 25px;
      font-weight: 1000;
      font-size: clamp(44px, 4.2vw, 72px);
      line-height: 0.98;
      letter-spacing: .3px;
    }

    .heroHeadline .muted{
      color: rgba(233,238,246,0.50);
      font-weight: 1000;
    }

    .heroLogos{
      display:flex;
      align-items:center;
      gap: 10px;
      margin: 8px 0 6px;
      padding: 8px 10px;
      border-radius: 999px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.10);
      width: fit-content;
      max-width: 100%;
      overflow:auto;
      scrollbar-width: none;
    }

    .heroLogos::-webkit-scrollbar{ display:none; }

    .heroLogos img{
      width: 20px;
      height: 20px;
      display:block;
      filter: drop-shadow(0 10px 18px rgba(0,0,0,0.35));
    }

    .heroRow{
      display:flex;
      align-items:center;
      gap: 14px;
      flex-wrap:wrap;
      margin-top: 14px;
    }

    .userChip{
      border-radius: 999px;
      padding: 16px 18px;
      display:inline-flex;
      align-items:center;
      gap: 16px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      width: fit-content;
      max-width: 100%;
    }

    .avatars{
      display:flex;
      align-items:center;
      padding-left: 6px;
      flex: 0 0 auto;
    }

    .avatar{
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 2px solid rgba(0,0,0,0.40);
      background: rgba(255,255,255,0.10);
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      overflow: hidden;
      background-clip: padding-box;
      clip-path: circle(50% at 50% 50%);
      box-shadow: 0 14px 30px rgba(0,0,0,0.35);
      margin-left: 0;
    }

    .avatar + .avatar{
      margin-left: -30px;
    }

    .userStat{
      display:flex;
      flex-direction:column;
      gap: 2px;
      min-width: 0;
    }

    .userStat .big{ font-weight: 1000; font-size: 28px; line-height: 1; }
    .userStat .sub{ color: rgba(233,238,246,0.70); font-weight: 800; font-size: 13px; }

    .ctaRow{
      display:flex;
      align-items:center;
      gap: 14px;
      flex-wrap:wrap;
      margin-top: 12px;
    }

    .ctaCombo{
      position:relative;
      display:flex;
      align-items:center;
      gap: 14px;
      padding: 5px;
      border-radius: 999px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.12);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      box-shadow: 0 22px 50px rgba(0,0,0,0.35);
      max-width: 620px;
      width: fit-content;
    }

    .ctaCombo::before{
      content:"";
      position:absolute;
      inset:-6px;
      border-radius: 999px;
      border: 1px dashed rgba(184,255,0,0.35);
      opacity: .55;
      pointer-events:none;
    }

    .ctaCombo .heroCta{
      margin: 0;
      box-shadow:none;
    }

    .ctaComboInfo{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 18px;
      padding-right: 12px;
      min-width: 220px;
      color: rgba(233,238,246,0.90);
      font-weight: 900;
    }

    .ctaComboText{
      font-size: 13px;
      line-height: 1.2;
      color: rgba(233,238,246,0.88);
      font-weight: 900;
    }

    .ctaComboMoney{
      font-weight: 1000;
      font-size: 38px;
      color: var(--accent);
      letter-spacing: .3px;
      line-height: 1;
      white-space:nowrap;
    }

    @media (max-width: 1050px){
      .ctaCombo{ width: 100%; max-width: 100%; }
      .ctaComboInfo{ flex: 1 1 auto; min-width: 0; }
    }

    .heroCta{
      padding: 14px 22px;
      border-radius: 999px;
      border: 1px solid rgba(184,255,0,0.55);
      background: rgba(184,255,0,0.95);
      color: #071000;
      font-weight: 1000;
      font-size: 16px;
      cursor:pointer;
      user-select:none;
      display:inline-flex;
      align-items:center;
      gap: 12px;
      box-shadow: 0 22px 50px rgba(0,0,0,0.45);
    }

    .heroCta .arrow{
      width: 12px;
      height: 12px;
      border-right: 3px solid #071000;
      border-bottom: 3px solid #071000;
      transform: rotate(-45deg);
      margin-top: 1px;
    }

    .bonusChip{
      border-radius: 999px;
      padding: 16px 18px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 18px;
      min-width: 280px;
    }

    .bonusChip .money{
      font-weight: 1000;
      font-size: 36px;
      color: var(--accent);
      letter-spacing: .3px;
      line-height: 1;
    }

    .noteChip{
      margin-top: 10px;
      border-radius: 18px;
      padding: 11px 13px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.10);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      display:flex;
      align-items:flex-start;
      gap: 12px;
      max-width: 620px;
    }

    .noteIcon{
      width: 46px;
      height: 46px;
      border-radius: 14px;
      background: rgba(184,255,0,0.10);
      border: 1px solid rgba(184,255,0,0.22);
      display:grid;
      place-items:center;
      flex: 0 0 auto;
    }

    .noteIcon i{
      font-size: 26px;
      color: var(--lime);
      filter: drop-shadow(0 10px 18px rgba(0,0,0,0.35));
    }

    .noteText .h{ color:#fff; font-weight: 950; font-size: 14px; }
    .noteText .p{ color: rgba(233,238,246,0.72); font-weight: 800; font-size: 13px; }

    .heroArt{
      position:relative;
      min-height: 460px;
      display:grid;
      place-items:start;
      justify-items:start;
      align-content:start;
    }

    .heroArt::before{ display:none; }

    .heroImg{
      width: min(520px, 100%);
      margin: 0;
      height: auto;
      display:block;
      filter: none;
      user-select:none;
    }

    @media (max-width: 1050px){
      .heroLinks{ display:none; }
      .heroMain{ grid-template-columns: 1fr; }
      .heroLeft{ margin-left: 0; max-width: 100%; }
      .heroArt{ min-height: 420px; }
      .userChip{ max-width: 100%; flex-wrap: wrap; }
      .ctaCombo{ width: 100%; max-width: 100%; }
      .ctaComboInfo{ flex: 1 1 auto; min-width: 0; }
    }

    @media (max-width: 520px){
      .brandName{ font-size: 22px; }
      .heroHeadline{ font-size: 48px; }
      .heroKicker{ font-size: 16px; }
      .pillBtn{ padding: 9px 12px; }
      .langPill{ padding: 8px 10px; }
    }

  </style>
</head>

<body>
  <div class="bg-3d" aria-hidden="true">
    <div class="scene" id="cubeScene"></div>
  </div>
  <div class="wrap">
    <!-- Hero section (uses img/bg.png) -->
    <section class="hero" aria-label="Hero">
      <div class="heroNav">
        <div class="brand" aria-label="wexon">
          <div class="brandMark" aria-hidden="true"><span></span></div>
          <div class="brandName">wexon</div>
        </div>

        <div class="heroLinks" aria-label="Primary navigation">
          <a href="#">Home</a>
          <a href="#">Marketing</a>
          <a href="#">Calculator</a>
          <a href="#">Partners</a>
          <a href="#">Statistics</a>
          <a href="#">FAQ</a>
          <a href="#">Support</a>
        </div>

        <div class="heroRightNav">
          <div class="langPill" aria-label="Language">
            <span style="opacity:.9">🌐</span>
            <span>EN</span>
          </div>
          <button class="pillBtn ghost" type="button">Login</button>
          <button class="pillBtn" type="button">Sign up</button>
        </div>
      </div>

      <div class="heroMain">
        <div class="heroLeft">
          <div class="heroKicker"><span class="acc">Innovative</span> cloud mining <span class="acc">system</span></div>

          <div class="heroLogos" aria-label="Supported coins">
            <img alt="Bitcoin" loading="lazy" decoding="async" src="https://api.iconify.design/simple-icons:bitcoin.svg?color=%23B8FE08&width=22&height=22">
            <img alt="Ethereum" loading="lazy" decoding="async" src="https://api.iconify.design/simple-icons:ethereum.svg?color=%23B8FE08&width=22&height=22">
            <img alt="Tether" loading="lazy" decoding="async" src="https://api.iconify.design/simple-icons:tether.svg?color=%23B8FE08&width=22&height=22">
            <img alt="BNB" loading="lazy" decoding="async" src="https://api.iconify.design/simple-icons:binance.svg?color=%23B8FE08&width=22&height=22">
            <img alt="Solana" loading="lazy" decoding="async" src="https://api.iconify.design/simple-icons:solana.svg?color=%23B8FE08&width=22&height=22">
          </div>

          <h1 class="heroHeadline">Cloud<br/><span class="muted">Mining</span></h1>

          <div class="heroRow">
            <div class="userChip" role="group" aria-label="Active daily users">
              <div class="avatars" aria-hidden="true">
                <span class="avatar"></span><span class="avatar"></span><span class="avatar"></span><span class="avatar"></span><span class="avatar"></span><span class="avatar"></span><span class="avatar"></span><span class="avatar"></span>
              </div>
              <div class="userStat">
                <div class="big">10k +</div>
                <div class="sub">Active Daily Users</div>
              </div>
            </div>
          </div>

          <div class="ctaRow">
            <div class="ctaCombo" role="group" aria-label="Start mining and bonus">
              <button class="heroCta" type="button">Start mining <span class="arrow" aria-hidden="true"></span></button>
              <div class="ctaComboInfo">
                <div class="ctaComboText">And get bonus<br/>for registration</div>
                <div class="ctaComboMoney">$3</div>
              </div>
            </div>
          </div>

          <div class="noteChip" role="note" aria-label="Free faucet">
            <div class="noteIcon" aria-hidden="true">
              <i class="fa-solid fa-faucet" aria-hidden="true"></i>
            </div>
            <div class="noteText">
              <div class="h">Free Bitcoin faucet after registration</div>
              <div class="p">Get Bitcoins every day even without investments</div>
            </div>
          </div>
        </div>

        <div class="heroArt" aria-label="Hero art">
          <img class="heroImg" src="img/bg.png" alt="Cloud mining illustration" />
        </div>
      </div>
    </section>

    <h1 class="title">Mining <span class="accent">calculator</span>.</h1>

    <div class="layout">
      <!-- LEFT -->
      <aside class="side glass">
        <div class="centerTitle">Investment currency</div>

        <!-- Investment currency dropdown (like screenshot) -->
        <div class="ddWrap" id="icWrap">
          <button class="ddBtn" id="icBtn" type="button" aria-haspopup="listbox" aria-expanded="false">
            <div class="ddLeft">
              <span class="ddIcon" id="icIcon"></span>
              <span class="ddName" id="icName">Tron</span>
            </div>

            <span class="ddTicker" id="icTicker">TRX</span>
            <span class="ddChevron" aria-hidden="true"></span>
          </button>

          <div class="ddMenu" id="icMenu" role="listbox" aria-label="Investment currencies list">
            <!-- items injected by JS -->
          </div>
        </div>

        <div class="label" style="margin-top:18px;">Investment amount</div>
        <div class="field">
          <div class="row">
            <input id="amountInput" class="amountInput" type="text" value="9728.79965079" />
            <span class="suffix" id="amountSuffix">TRX</span>
          </div>
        </div>

        <input id="amountRange" type="range" min="0" max="20000" value="9729" />
        <div class="arc"></div>
      </aside>

      <!-- CENTER -->
      <main class="center glass">
        <!-- background decor -->
        <div class="centerDecor" aria-hidden="true">
          <div class="centerGlow"></div>
          <svg class="centerWave" viewBox="0 0 1000 400" preserveAspectRatio="none">
            <defs>
              <linearGradient id="waveFill" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#b8ff00" stop-opacity="0" />
                <stop offset="55%" stop-color="#b8ff00" stop-opacity="0.10" />
                <stop offset="100%" stop-color="#b8ff00" stop-opacity="0.55" />
              </linearGradient>

              <linearGradient id="waveLine" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0%" stop-color="#b8ff00" stop-opacity="0.35" />
                <stop offset="45%" stop-color="#b8ff00" stop-opacity="0.95" />
                <stop offset="100%" stop-color="#b8ff00" stop-opacity="0.55" />
              </linearGradient>

              <pattern id="diag" width="14" height="14" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                <rect x="0" y="0" width="6" height="14" fill="#b8ff00" opacity="1" />
              </pattern>

              <clipPath id="waveClip">
                <path d="M0 235 C 120 220 210 320 360 290 C 520 255 640 160 770 205 C 875 240 940 165 1000 145 L 1000 400 L 0 400 Z" />
              </clipPath>
            </defs>

            <!-- wave fill -->
            <path class="waveFill" d="M0 235 C 120 220 210 320 360 290 C 520 255 640 160 770 205 C 875 240 940 165 1000 145 L 1000 400 L 0 400 Z" fill="url(#waveFill)" />

            <!-- striped overlay inside the wave -->
            <rect class="waveStripes" x="0" y="0" width="1000" height="400" fill="url(#diag)" clip-path="url(#waveClip)" />

            <!-- neon line on top of the wave -->
            <path class="waveLine" d="M0 235 C 120 220 210 320 360 290 C 520 255 640 160 770 205 C 875 240 940 165 1000 145" fill="none" stroke="url(#waveLine)" stroke-width="8" stroke-linecap="round" />
            <path class="waveLine" d="M0 235 C 120 220 210 320 360 290 C 520 255 640 160 770 205 C 875 240 940 165 1000 145" fill="none" stroke="#b8ff00" stroke-opacity="0.35" stroke-width="14" stroke-linecap="round" />
          </svg>
        </div>
        <!-- Profitability bubbles -->
        <div class="bubbleTitle">Daily profitability</div>

        <div class="bubbleLabels" id="profitLabels"></div>

        <div class="bubbleRail" id="profitRail">
          <div class="bubbleTrack" id="profitTrack"></div>
          <div class="bubblePill" id="profitPill">7 Level</div>
        </div>

        <div class="twoBoxes">
          <div class="miniBox">
            <div class="k">Price 1TH/s</div>
            <div class="v" id="pricePerTh">$1</div>
          </div>
          <div class="miniBox">
            <div class="k">Hashrate</div>
            <div class="v">
              <span id="hashrate">2829.00</span>
              <span style="font-size:14px;color:rgba(184,255,0,.75);font-weight:850;">TH/s</span>
            </div>
          </div>
        </div>

        <div class="profits">
          <div class="profitCard">
            <div class="k">Hourly profit</div>
            <div class="big" id="hourlyBtc">0.00005008btc</div>
            <div class="usd" id="hourlyUsd">≈ $4.4855</div>
          </div>
          <div class="profitCard">
            <div class="k">Daily profit</div>
            <div class="big" id="dailyBtc">0.00120192btc</div>
            <div class="usd" id="dailyUsd">≈ $107.6532</div>
          </div>
          <div class="profitCard">
            <div class="k">Weekly profit</div>
            <div class="big" id="weeklyBtc">0.00841343btc</div>
            <div class="usd" id="weeklyUsd">≈ $753.5722</div>
          </div>
        </div>

        <div class="bottomRow">
          <div class="profitCard">
            <div class="k">Monthly profit</div>
            <div class="big" id="monthlyBtc">0.03725948btc</div>
            <div class="usd" id="monthlyUsd">≈ $3337.2482</div>
          </div>
          <div class="profitCard">
            <div class="k">Annual profit</div>
            <div class="big" id="annualBtc">0.43870038btc</div>
            <div class="usd" id="annualUsd">≈ $39293.4063</div>
          </div>
          <button class="cta" type="button">Start<br/>mining</button>
        </div>
      </main>

      <!-- RIGHT -->
      <aside class="side glass">
        <div class="label">Mining currency:</div>

        <!-- Mining currency dropdown -->
        <div class="ddWrap" id="mcWrap">
          <button class="ddBtn" id="mcBtn" type="button" aria-haspopup="listbox" aria-expanded="false">
            <div class="ddLeft">
              <span class="ddIcon" id="mcIcon"></span>
              <span class="ddName" id="mcName">Bitcoin</span>
            </div>
            <span class="ddTicker" id="mcTicker">BTC</span>
            <span class="ddChevron" aria-hidden="true"></span>
          </button>

          <div class="ddMenu" id="mcMenu" role="listbox" aria-label="Mining currency list">
            <!-- injected by JS -->
          </div>
        </div>

        <div class="label" style="margin-top:18px;">Days without withdrawal:</div>
        <div class="field">
          <input id="daysInput" class="amountInput" type="text" value="131" />
        </div>

        <input id="daysRange" type="range" min="0" max="365" value="131" />
        <div class="arc right"></div>
      </aside>
    </div>

    <!-- Marketing section (like screenshot) -->
    <section class="marketing" aria-label="Marketing">
      <h2 class="mkTitle">Marketing</h2>

      <div class="mkGrid">
        <article class="mkCard glass">
          <header class="mkHeader">
            <div class="mkIcon" aria-hidden="true">Ł</div>
            <div class="mkName">Scrypt</div>
          </header>
          <div class="mkBody">
            <table class="mkTable" aria-label="Scrypt marketing table">
              <thead>
                <tr>
                  <th>Investment amount</th>
                  <th>Daily profit</th>
                  <th>Purchased hashrate</th>
                </tr>
              </thead>
              <tbody id="mkScrypt"></tbody>
            </table>
          </div>
        </article>

        <article class="mkCard glass">
          <header class="mkHeader">
            <div class="mkIcon" aria-hidden="true">₿</div>
            <div class="mkName">SHA-256</div>
          </header>
          <div class="mkBody">
            <table class="mkTable" aria-label="SHA-256 marketing table">
              <thead>
                <tr>
                  <th>Investment amount</th>
                  <th>Daily profit</th>
                  <th>Purchased hashrate</th>
                </tr>
              </thead>
              <tbody id="mkSha"></tbody>
            </table>
          </div>
        </article>

        <article class="mkCard glass">
          <header class="mkHeader">
            <div class="mkIcon" aria-hidden="true">➜</div>
            <div class="mkName">KHeavyHash</div>
          </header>
          <div class="mkBody">
            <table class="mkTable" aria-label="KHeavyHash marketing table">
              <thead>
                <tr>
                  <th>Investment amount</th>
                  <th>Daily profit</th>
                  <th>Purchased hashrate</th>
                </tr>
              </thead>
              <tbody id="mkKheavy"></tbody>
            </table>
          </div>
        </article>
      </div>
    </section>

    <!-- Wexon statistics section (like screenshot) -->
    <section class="stats" aria-label="Wexon statistics">
      <div class="statsHeader">
        <h2 class="statsTitle"><span class="w">Wexon</span> <span class="s">statistics</span></h2>
        <div class="growCallout" aria-label="We are growing">
          <span class="growIcon" aria-hidden="true">
            <img class="growIconImg" alt="" loading="lazy" decoding="async" src="https://api.iconify.design/mdi:arrow-top-right.svg?color=%23071000&width=28&height=28">
          </span>
          <span class="growText">We are growing</span>
        </div>
      </div>

      <div class="statsGrid">
        <article class="statCard glass" aria-label="Days online">
          <div class="statTop">
            <span class="statIcon" aria-hidden="true">
              <img alt="" loading="lazy" decoding="async" src="https://api.iconify.design/mdi:calendar-check.svg?color=%23b8ff00&width=22&height=22">
            </span>
            <span>Days online</span>
          </div>
          <div class="statValue" id="statDays">210</div>
        </article>

        <article class="statCard glass" aria-label="Users">
          <div class="statTop">
            <span class="statIcon" aria-hidden="true">
              <img alt="" loading="lazy" decoding="async" src="https://api.iconify.design/mdi:account-group.svg?color=%23b8ff00&width=22&height=22">
            </span>
            <span>Users</span>
          </div>
          <div class="statValue statValueMd" id="statUsers">112,791</div>
          <div class="statSub" id="statUsersDelta">+1000 today</div>
        </article>

        <article class="statCard glass" aria-label="Total deposits">
          <div class="statTop">
            <span class="statIcon" aria-hidden="true">
              <img alt="" loading="lazy" decoding="async" src="https://api.iconify.design/mdi:bank-plus.svg?color=%23b8ff00&width=22&height=22">
            </span>
            <span>Total deposits</span>
          </div>
          <div class="statValue statValueMd" id="statDeposits">5,658,636</div>
          <div class="statUnit">usd</div>
        </article>

        <article class="statCard glass" aria-label="Total withdrawals">
          <div class="statTop">
            <span class="statIcon" aria-hidden="true">
              <img alt="" loading="lazy" decoding="async" src="https://api.iconify.design/mdi:bank-minus.svg?color=%23b8ff00&width=22&height=22">
            </span>
            <span>Total withdrawals</span>
          </div>
          <div class="statValue statValueMd" id="statWithdrawals">1,521,596</div>
          <div class="statUnit">usd</div>
        </article>
      </div>
    </section>

    <!-- Client testimonials -->
    <section class="testimonials" aria-label="Client feedback">
      <div class="testimonialsHeader">
        <h2 class="statsTitle"><span class="w">Client</span> <span class="s">feedback</span></h2>
        <div class="testimonialControls" aria-label="Testimonial navigation">
          <button class="testimonialBtn" type="button" data-dir="prev" aria-label="Previous testimonial">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
          </button>
          <button class="testimonialBtn" type="button" data-dir="next" aria-label="Next testimonial">
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
          </button>
        </div>
      </div>

      <div class="testimonialGrid glass" id="testimonialGrid" aria-live="polite"></div>
    </section>

    <!-- Latest deposits / withdrawals section (like screenshot) -->
    <section class="latest" aria-label="Latest deposits and withdrawals">
      <div class="latestGrid">
        <div>
          <h2 class="latestTitle">Latest deposits</h2>
          <div class="latestCard glass">
            <table class="latestTable" aria-label="Latest deposits table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody id="latestDeposits"></tbody>
            </table>
          </div>
        </div>

        <div>
          <h2 class="latestTitle">Latest withdrawals</h2>
          <div class="latestCard glass">
            <table class="latestTable" aria-label="Latest withdrawals table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody id="latestWithdrawals"></tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Affiliate section (like screenshot) -->
    <section class="affiliate" aria-label="Affiliate program">
      <div class="affTopBar">
        <h2 class="statsTitle"><span class="w">Affiliate</span> <span class="s">program</span></h2>
      </div>
      <div class="affGrid">
        <div class="affLeft glass">
          <div class="affGraph" aria-label="Affiliate steps and rewards">
            <canvas class="affCanvas" id="affCanvas" aria-hidden="true"></canvas>

            <div class="affStep s1">
              <div class="affStepBadge">1<span>1% bonus</span></div>
              <div class="affMeta">
                <div class="lvl">Step 1</div>
                <div>Share your link and invite friends to get your first rewards.</div>
              </div>
            </div>

            <div class="affStep s2">
              <div class="affStepBadge">2<span>3% bonus</span></div>
              <div class="affMeta">
                <div class="lvl">Step 2</div>
                <div>Earn more when your friends activate their mining power.</div>
              </div>
            </div>

            <div class="affStep s3">
              <div class="affStepBadge">3<span>5% bonus</span></div>
              <div class="affMeta">
                <div class="lvl">Step 3</div>
                <div>Grow your network and keep collecting higher tier rewards.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="affRight">
          <h2 class="affTitle">Invite friends <span class="acc">and<br/>get rewards</span></h2>

          <p class="affText">After registration, receive a unique affiliate link and share the link with your friends.</p>

          <p class="affText">For each friend who registers via your link, you will receive a hashrate of 0.05 TH/s using the SHA-256 algorithm, which is equal to $0.05. If a friend makes a deposit and buys a hashrate, you will receive a share of his purchased hashrate.</p>

          <button class="affBtn" type="button">Become a partner</button>
        </div>
      </div>
    </section>

    <footer class="site-footer glass">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="footer-title">Coin Trade</div>
          <p class="footer-copy">Canada's leading cryptocurrency trading platform. Trade with confidence, security, and speed.</p>
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
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Help Center</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Legal</h3>
          <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Cookie Policy</a></li>
            <li><a href="#">Compliance</a></li>
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
      </div>

      <div class="footer-bottom">
        <span>© 2026 Coin Trade. All rights reserved.</span>
        <span>Built for fast, secure, and compliant crypto trading.</span>
      </div>
    </footer>
  </div>

  <script>
    // ===== 3D cubes background (fused) =====
    (function initCubes(){
      const scene = document.getElementById("cubeScene");
      if (!scene) return;

      const prefersReduced = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
      const isSmall = window.matchMedia?.("(max-width: 520px)")?.matches;

      const COUNT = prefersReduced ? 90 : (isSmall ? 110 : 170);

      function rand(min, max){
        return Math.random() * (max - min) + min;
      }

      function makeCube(){
        const cube = document.createElement("div");
        cube.className = "cube";

        const faces = ["front","back","right","left","top","bottom"];
        for (const name of faces) {
          const face = document.createElement("div");
          face.className = `face ${name}`;
          cube.appendChild(face);
        }

        return cube;
      }

      function populate(){
        scene.innerHTML = "";

        const w = window.innerWidth;
        const h = window.innerHeight;

        for (let i = 0; i < COUNT; i++) {
          const cube = makeCube();

          const size = Math.round(rand(18, 84));
          const x = Math.round(rand(-size, w + size));
          const y = Math.round(rand(-size, h + size));
          const z = Math.round(rand(-900, 120));

          const rx = Math.round(rand(0, 360));
          const ry = Math.round(rand(0, 360));
          const rz = Math.round(rand(0, 360));

          const hue = Math.round(rand(170, 320));
          const alpha = rand(0.08, 0.24).toFixed(2);
          const dur = `${Math.round(rand(18, 46))}s`;

          cube.style.setProperty("--s", `${size}px`);
          cube.style.setProperty("--x", `${x}px`);
          cube.style.setProperty("--y", `${y}px`);
          cube.style.setProperty("--z", `${z}px`);
          cube.style.setProperty("--rx", `${rx}deg`);
          cube.style.setProperty("--ry", `${ry}deg`);
          cube.style.setProperty("--rz", `${rz}deg`);
          cube.style.setProperty("--dur", dur);
          cube.style.setProperty("--h", `${hue}`);
          cube.style.setProperty("--a", `${alpha}`);

          scene.appendChild(cube);
        }
      }

      let resizeTimer = null;
      window.addEventListener("resize", () => {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(populate, 140);
      }, { passive: true });

      populate();
    })();

    // ===== Profitability bubble data =====
    const profitabilitySteps = [1, 1.1, 1.3, 1.5, 2, 2.2, 2.5, 3, 3.5, 4, 5];
    let selectedProfitIndex = 7; // default like screenshot (3%)

    // ===== Free crypto icons (CDN) =====
    // spothq/cryptocurrency-icons via jsDelivr (CC0)
    const CRYPTO_ICON_BASE = "https://cdn.jsdelivr.net/npm/cryptocurrency-icons@0.18.1/svg/color/";
    const CRYPTO_FALLBACK = CRYPTO_ICON_BASE + "generic.svg";

    const COIN_SLUG = {
      BTC: "btc",
      ETH: "eth",
      USDT: "usdt",
      BNB: "bnb",
      XRP: "xrp",
      USDC: "usdc",
      SOL: "sol",
      STETH: "eth",
      TRX: "trx",
      DOGE: "doge",
      ADA: "ada",
      BCH: "bch",
      WBTC: "btc",
      WBETH: "eth",
      WEETH: "eth",
      WETH: "eth",
      WSTETH: "eth",
      XMR: "xmr",
      LEO: "leo",
      LINK: "link",
      XLM: "xlm",
      ZEC: "zec",
      LTC: "ltc",
      SUI: "sui",
      AVAX: "avax",
      SHIB: "shib",
      HBAR: "hbar",
      DAI: "dai",
      PYUSD: "pyusd",
      TON: "ton",
      CRO: "cro",
      DOT: "dot",
      UNI: "uni",
      MNT: "mnt",
      XAUT: "xaut",
      "BSC-USD": "usdt",
      CBBTC: "btc",
      USDT0: "usdt",
      USDS: "usdc",
      USDE: "usdc",
      SUSDE: "usdc",
      SUSDS: "usdc",
      USD1: "usdc",
      WBT: "generic",
      M: "generic",
      FIGR_HELOC: "generic",
      WLFI: "generic",
      CC: "generic",
      HYPE: "generic",
      RAIN: "generic",
    };

    function coinIconUrl(ticker){
      const t = String(ticker || "").toUpperCase();
      const slug = COIN_SLUG[t] || "generic";
      return CRYPTO_ICON_BASE + slug + ".svg";
    }

    function coinImgHTML(ticker){
      const url = coinIconUrl(ticker);
      const t = String(ticker || "").toUpperCase();
      return `<img class="coinImg" src="${url}" alt="${t}" onerror="this.onerror=null;this.src='${CRYPTO_FALLBACK}'">`;
    }

    // ===== Investment currencies =====
    const investmentCurrencies = [
      { key: "BTC", name: "Bitcoin", ticker: "BTC" },
      { key: "ETH", name: "Ethereum", ticker: "ETH" },
      { key: "USDT", name: "Tether", ticker: "USDT" },
      { key: "BNB", name: "BNB", ticker: "BNB" },
      { key: "XRP", name: "XRP", ticker: "XRP" },
      { key: "USDC", name: "USDC", ticker: "USDC" },
      { key: "SOL", name: "Solana", ticker: "SOL" },
      { key: "STETH", name: "Lido Staked Ether", ticker: "STETH" },
      { key: "TRX", name: "TRON", ticker: "TRX" },
      { key: "DOGE", name: "Dogecoin", ticker: "DOGE" },
      { key: "FIGR_HELOC", name: "Figure Heloc", ticker: "FIGR_HELOC" },
      { key: "ADA", name: "Cardano", ticker: "ADA" },
      { key: "WSTETH", name: "Wrapped stETH", ticker: "WSTETH" },
      { key: "BCH", name: "Bitcoin Cash", ticker: "BCH" },
      { key: "WBT", name: "WhiteBIT Coin", ticker: "WBT" },
      { key: "WBTC", name: "Wrapped Bitcoin", ticker: "WBTC" },
      { key: "WBETH", name: "Wrapped Beacon ETH", ticker: "WBETH" },
      { key: "WEETH", name: "Wrapped eETH", ticker: "WEETH" },
      { key: "WETH", name: "WETH", ticker: "WETH" },
      { key: "USDS", name: "USDS", ticker: "USDS" },
      { key: "BSC_USD", name: "Binance Bridged USDT (BNB Smart Chain)", ticker: "BSC-USD", badge: { text: "B", class: "badge-bnb" } },
      { key: "USDT_TRC20", name: "Tether (TRC20)", ticker: "USDT", badge: { text: "TR", class: "badge-trx" } },
      { key: "XMR", name: "Monero", ticker: "XMR" },
      { key: "LEO", name: "LEO Token", ticker: "LEO" },
      { key: "LINK", name: "Chainlink", ticker: "LINK" },
      { key: "HYPE", name: "Hyperliquid", ticker: "HYPE" },
      { key: "CBBTC", name: "Coinbase Wrapped BTC", ticker: "CBBTC" },
      { key: "XLM", name: "Stellar", ticker: "XLM" },
      { key: "USDE", name: "Ethena USDe", ticker: "USDE" },
      { key: "ZEC", name: "Zcash", ticker: "ZEC" },
      { key: "CC", name: "Canton", ticker: "CC" },
      { key: "LTC", name: "Litecoin", ticker: "LTC" },
      { key: "SUI", name: "Sui", ticker: "SUI" },
      { key: "AVAX", name: "Avalanche", ticker: "AVAX" },
      { key: "USD1", name: "USD1", ticker: "USD1" },
      { key: "SHIB", name: "Shiba Inu", ticker: "SHIB" },
      { key: "HBAR", name: "Hedera", ticker: "HBAR" },
      { key: "WLFI", name: "World Liberty Financial", ticker: "WLFI" },
      { key: "USDT0", name: "USDT0", ticker: "USDT0" },
      { key: "DAI", name: "Dai", ticker: "DAI" },
      { key: "SUSDS", name: "sUSDS", ticker: "SUSDS" },
      { key: "PYUSD", name: "PayPal USD", ticker: "PYUSD" },
      { key: "SUSDE", name: "Ethena Staked USDe", ticker: "SUSDE" },
      { key: "TON", name: "Toncoin", ticker: "TON" },
      { key: "CRO", name: "Cronos", ticker: "CRO" },
      { key: "RAIN", name: "Rain", ticker: "RAIN" },
      { key: "DOT", name: "Polkadot", ticker: "DOT" },
      { key: "UNI", name: "Uniswap", ticker: "UNI" },
      { key: "MNT", name: "Mantle", ticker: "MNT" },
      { key: "XAUT", name: "Tether Gold", ticker: "XAUT" },
      { key: "M", name: "MemeCore", ticker: "M" },
    ];

    let selectedInvestmentKey = "TRX"; // default

    // ===== Mining currency dropdown data =====
    const miningCurrencies = [
      { name: "Bitcoin", ticker: "BTC" },
      { name: "Ethereum", ticker: "ETH" },
      { name: "Tether", ticker: "USDT" },
      { name: "BNB", ticker: "BNB" },
      { name: "XRP", ticker: "XRP" },
      { name: "USDC", ticker: "USDC" },
      { name: "Solana", ticker: "SOL" },
      { name: "Lido Staked Ether", ticker: "STETH" },
      { name: "TRON", ticker: "TRX" },
      { name: "Dogecoin", ticker: "DOGE" },
      { name: "Figure Heloc", ticker: "FIGR_HELOC" },
      { name: "Cardano", ticker: "ADA" },
      { name: "Wrapped stETH", ticker: "WSTETH" },
      { name: "Bitcoin Cash", ticker: "BCH" },
      { name: "WhiteBIT Coin", ticker: "WBT" },
      { name: "Wrapped Bitcoin", ticker: "WBTC" },
      { name: "Wrapped Beacon ETH", ticker: "WBETH" },
      { name: "Wrapped eETH", ticker: "WEETH" },
      { name: "USDS", ticker: "USDS" },
      { name: "Binance Bridged USDT (BNB Smart Chain)", ticker: "BSC-USD" },
      { name: "Monero", ticker: "XMR" },
      { name: "LEO Token", ticker: "LEO" },
      { name: "Chainlink", ticker: "LINK" },
      { name: "Hyperliquid", ticker: "HYPE" },
      { name: "Coinbase Wrapped BTC", ticker: "CBBTC" },
      { name: "WETH", ticker: "WETH" },
      { name: "Stellar", ticker: "XLM" },
      { name: "Ethena USDe", ticker: "USDE" },
      { name: "Zcash", ticker: "ZEC" },
      { name: "Canton", ticker: "CC" },
      { name: "Litecoin", ticker: "LTC" },
      { name: "Sui", ticker: "SUI" },
      { name: "Avalanche", ticker: "AVAX" },
      { name: "USD1", ticker: "USD1" },
      { name: "Shiba Inu", ticker: "SHIB" },
      { name: "Hedera", ticker: "HBAR" },
      { name: "World Liberty Financial", ticker: "WLFI" },
      { name: "USDT0", ticker: "USDT0" },
      { name: "Dai", ticker: "DAI" },
      { name: "sUSDS", ticker: "SUSDS" },
      { name: "PayPal USD", ticker: "PYUSD" },
      { name: "Ethena Staked USDe", ticker: "SUSDE" },
      { name: "Toncoin", ticker: "TON" },
      { name: "Cronos", ticker: "CRO" },
      { name: "Rain", ticker: "RAIN" },
      { name: "Polkadot", ticker: "DOT" },
      { name: "Uniswap", ticker: "UNI" },
      { name: "Mantle", ticker: "MNT" },
      { name: "Tether Gold", ticker: "XAUT" },
      { name: "MemeCore", ticker: "M" },
    ];
    let selectedMiningTicker = "BTC";

    // ===== Elements =====
    const els = {
      amountInput: document.getElementById('amountInput'),
      amountSuffix: document.getElementById('amountSuffix'),
      amountRange: document.getElementById('amountRange'),
      daysInput: document.getElementById('daysInput'),
      daysRange: document.getElementById('daysRange'),

      pricePerTh: document.getElementById('pricePerTh'),
      hashrate: document.getElementById('hashrate'),

      hourlyBtc: document.getElementById('hourlyBtc'),
      dailyBtc: document.getElementById('dailyBtc'),
      weeklyBtc: document.getElementById('weeklyBtc'),
      monthlyBtc: document.getElementById('monthlyBtc'),
      annualBtc: document.getElementById('annualBtc'),

      hourlyUsd: document.getElementById('hourlyUsd'),
      dailyUsd: document.getElementById('dailyUsd'),
      weeklyUsd: document.getElementById('weeklyUsd'),
      monthlyUsd: document.getElementById('monthlyUsd'),
      annualUsd: document.getElementById('annualUsd'),

      profitLabels: document.getElementById('profitLabels'),
      profitRail: document.getElementById('profitRail'),
      profitTrack: document.getElementById('profitTrack'),
      profitPill: document.getElementById('profitPill'),

      // investment dropdown
      icWrap: document.getElementById('icWrap'),
      icBtn: document.getElementById('icBtn'),
      icMenu: document.getElementById('icMenu'),
      icIcon: document.getElementById('icIcon'),
      icName: document.getElementById('icName'),
      icTicker: document.getElementById('icTicker'),

      // mining dropdown
      mcWrap: document.getElementById('mcWrap'),
      mcBtn: document.getElementById('mcBtn'),
      mcMenu: document.getElementById('mcMenu'),
      mcIcon: document.getElementById('mcIcon'),
      mcName: document.getElementById('mcName'),
      mcTicker: document.getElementById('mcTicker'),
    };

    function formatNum(n, d=2){
      return Number(n).toLocaleString(undefined, { maximumFractionDigits: d, minimumFractionDigits: d });
    }

    function computeProfitIndex(amount, days){
      const maxAmount = Number(els.amountRange?.max) || 20000;
      const a = Math.log10(1 + Math.max(0, amount)) / Math.log10(1 + maxAmount);
      const d = Math.max(0, Math.min(365, days)) / 365;
      const score = (0.55 * d) + (0.45 * a);
      const idx = Math.round(score * (profitabilitySteps.length - 1));
      return Math.max(0, Math.min(profitabilitySteps.length - 1, idx));
    }

    // ===== Profit bubbles (segments) =====
    function buildProfitBubbles(){
      els.profitLabels.innerHTML = "";
      els.profitTrack.innerHTML = "";

      profitabilitySteps.forEach((p, i) => {
        const label = document.createElement("span");
        label.textContent = p + "%";
        if (i >= 8) label.className = "dim"; // 3.5/4/5 dim
        els.profitLabels.appendChild(label);

        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "bubbleBtn";
        btn.addEventListener("click", () => {
          // Linked controls: clicking a level sets Days without withdrawal.
          const targetDays = Math.round((i / (profitabilitySteps.length - 1)) * 365);
          els.daysRange.value = String(targetDays);
          els.daysInput.value = String(targetDays);
          recalc();
        });
        els.profitTrack.appendChild(btn);

        if (i < profitabilitySteps.length - 1) {
          const seg = document.createElement("div");
          seg.className = "bubbleSeg";
          els.profitTrack.appendChild(seg);
        }
      });

      requestAnimationFrame(updateProfitBubbles);
    }

    function updateProfitBubbles(){
      const btns = Array.from(els.profitTrack.querySelectorAll(".bubbleBtn"));
      const segs = Array.from(els.profitTrack.querySelectorAll(".bubbleSeg"));

      btns.forEach((btn, i) => {
        btn.classList.remove("is-active","is-off","is-selected");
        if (i <= selectedProfitIndex) btn.classList.add("is-active");
        else btn.classList.add("is-off");
        if (i === selectedProfitIndex) btn.classList.add("is-selected");
      });

      segs.forEach((seg, i) => {
        seg.classList.toggle("is-active", i < selectedProfitIndex);
      });

      const selectedBtn = btns[selectedProfitIndex];
      if (!selectedBtn) return;

      const railRect = els.profitRail.getBoundingClientRect();
      const btnRect = selectedBtn.getBoundingClientRect();
      const centerX = (btnRect.left - railRect.left) + (btnRect.width / 2);

      // update pill text first so we can measure its width
      els.profitPill.textContent = `${selectedProfitIndex} Level • ${profitabilitySteps[selectedProfitIndex]}%`;

      // clamp pill so it never goes outside the panel
      const pillW = els.profitPill.offsetWidth || 0;
      const edgePad = 6;
      const minX = (pillW / 2) + edgePad;
      const maxX = railRect.width - (pillW / 2) - edgePad;
      const clampedX = Math.max(minX, Math.min(centerX, maxX));

      els.profitPill.style.left = clampedX + "px";
    }

    // ===== Helpers to build dropdown icon html =====
    function iconHTML(c, sizeClass){
      const badgeHTML = c.badge
        ? `<span class="ddBadge ${c.badge.class}">${c.badge.text}</span>`
        : "";
      return `<span class="${sizeClass}">${coinImgHTML(c.ticker)}${badgeHTML}</span>`;
    }

    // ===== Investment dropdown =====
    function renderInvestmentMenu(){
      els.icMenu.innerHTML = "";

      investmentCurrencies.forEach((c) => {
        const item = document.createElement("button");
        item.type = "button";
        item.className = "ddItem" + (c.key === selectedInvestmentKey ? " is-selected" : "");
        item.setAttribute("role", "option");
        item.setAttribute("aria-selected", c.key === selectedInvestmentKey ? "true" : "false");

        item.innerHTML = `
          <div class="ddItemLeft">
            ${iconHTML(c, "ddItemIcon")}
            <span class="ddItemName">${c.name}</span>
          </div>
          <span class="ddItemTicker">${c.ticker}</span>
        `;

        item.addEventListener("click", () => {
          selectedInvestmentKey = c.key;

          // update top button
          els.icIcon.className = "ddIcon";
          els.icIcon.innerHTML = coinImgHTML(c.ticker) +
            (c.badge ? `<span class="ddBadge ${c.badge.class}">${c.badge.text}</span>` : "");

          els.icName.textContent = c.name;
          els.icTicker.textContent = c.ticker;

          // update suffix
          els.amountSuffix.textContent = c.ticker;

          renderInvestmentMenu();

          // close
          els.icWrap.classList.remove("open");
          els.icBtn.setAttribute("aria-expanded", "false");

          recalc();
        });

        els.icMenu.appendChild(item);
      });
    }

    function initInvestment(){
      const init = investmentCurrencies.find(x => x.key === selectedInvestmentKey) || investmentCurrencies[0];

      els.icIcon.className = "ddIcon";
      els.icIcon.innerHTML = coinImgHTML(init.ticker) +
        (init.badge ? `<span class="ddBadge ${init.badge.class}">${init.badge.text}</span>` : "");

      els.icName.textContent = init.name;
      els.icTicker.textContent = init.ticker;
      els.amountSuffix.textContent = init.ticker;

      renderInvestmentMenu();
    }

    // ===== Mining dropdown =====
    function renderMiningMenu(){
      els.mcMenu.innerHTML = "";
      miningCurrencies.forEach((c) => {
        const item = document.createElement("button");
        item.type = "button";
        item.className = "ddItem" + (c.ticker === selectedMiningTicker ? " is-selected" : "");
        item.setAttribute("role", "option");
        item.setAttribute("aria-selected", c.ticker === selectedMiningTicker ? "true" : "false");

        item.innerHTML = `
          <div class="ddItemLeft">
            ${iconHTML(c, "ddItemIcon")}
            <span class="ddItemName">${c.name}</span>
          </div>
          <span class="ddItemTicker">${c.ticker}</span>
        `;

        item.addEventListener("click", () => {
          selectedMiningTicker = c.ticker;

          els.mcIcon.className = "ddIcon";
          els.mcIcon.innerHTML = coinImgHTML(c.ticker);

          els.mcName.textContent = c.name;
          els.mcTicker.textContent = c.ticker;

          renderMiningMenu();

          els.mcWrap.classList.remove("open");
          els.mcBtn.setAttribute("aria-expanded", "false");
          recalc();
        });

        els.mcMenu.appendChild(item);
      });
    }

    function initMining(){
      const init = miningCurrencies.find(x => x.ticker === selectedMiningTicker) || miningCurrencies[0];

      els.mcIcon.className = "ddIcon";
      els.mcIcon.innerHTML = coinImgHTML(init.ticker);

      els.mcName.textContent = init.name;
      els.mcTicker.textContent = init.ticker;

      renderMiningMenu();
    }

    // ===== Marketing tables (like screenshot) =====
    const marketingAmounts = [0, 10, 50, 100, 300, 500, 1000, 2000, 5000, 10000, 20000];

    const marketingTables = [
      {
        tbodyId: "mkScrypt",
        unit: "GH/s",
        hashrate: [0, 20, 100, 200, 600, 1000, 2000, 4000, 10000, 20000, 40000],
      },
      {
        tbodyId: "mkSha",
        unit: "TH/s",
        hashrate: [0, 10, 50, 100, 300, 500, 1000, 2000, 5000, 10000, 20000],
      },
      {
        tbodyId: "mkKheavy",
        unit: "TH/s",
        hashrate: [0, 100, 500, 1000, 3000, 5000, 10000, 20000, 50000, 100000, 200000],
      },
    ];

    function formatMoney(n){
      return "$" + Number(n).toLocaleString(undefined, { maximumFractionDigits: 0 });
    }

    function formatHash(n, unit){
      return `From ${Number(n).toLocaleString(undefined, { maximumFractionDigits: 0 })} ${unit}`;
    }

    function renderMarketingTables(){
      for (const t of marketingTables) {
        const tbody = document.getElementById(t.tbodyId);
        if (!tbody) continue;

        tbody.innerHTML = "";

        for (let i = 0; i < marketingAmounts.length; i++) {
          const amt = marketingAmounts[i];
          const pct = profitabilitySteps[i] ?? profitabilitySteps[0];
          const hr = t.hashrate[i] ?? 0;

          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${formatMoney(amt)}</td>
            <td>${pct}%</td>
            <td class="mkHash">${formatHash(hr, t.unit)}</td>
          `;
          tbody.appendChild(tr);
        }
      }
    }

    // ===== Latest deposits / withdrawals (demo data) =====
    const latestDepositsData = [
      { user: "hermanbtc66", amount: "0.30000000 BNB", date: "28.01.2026 16:46" },
      { user: "tabahnikovpeter1986", amount: "23,294.00000000 DOGE", date: "28.01.2026 16:35" },
      { user: "reje5", amount: "3.00000000 DASH", date: "28.01.2026 16:14" },
      { user: "deptpu", amount: "0.01691456 BCH", date: "28.01.2026 15:38" },
      { user: "marcinmat", amount: "0.20000000 DASH", date: "28.01.2026 15:20" },
      { user: "ivanlenur", amount: "0.10000000 BNB", date: "28.01.2026 15:04" },
      { user: "piero07", amount: "280.00 USDT", date: "28.01.2026 14:42" },
      { user: "abenilson_costa", amount: "16,377,649.33 XEC", date: "28.01.2026 14:38" },
      { user: "karyagin1982", amount: "2.51861730 BCH", date: "28.01.2026 14:28" },
      { user: "tawanchusri27", amount: "225.00000000 KAS", date: "28.01.2026 14:08" },
    ];

    const latestWithdrawalsData = [
      { user: "pithalee", amount: "0.01000000 BCH", date: "28.01.2026 16:59" },
      { user: "ginnyarora92", amount: "161.00000000 DOGE", date: "28.01.2026 16:54" },
      { user: "omermohamed600", amount: "20.00 USDT", date: "28.01.2026 16:45" },
      { user: "basovalex", amount: "241.00000000 TRX", date: "28.01.2026 16:43" },
      { user: "nelsonmartiz", amount: "6.99 USDT", date: "28.01.2026 16:41" },
      { user: "maribularca2003", amount: "252.72711512 KAS", date: "28.01.2026 16:35" },
      { user: "weib13", amount: "64.00000000 DOGE", date: "28.01.2026 16:34" },
      { user: "michellcastro4543", amount: "965,250.97 XEC", date: "28.01.2026 16:29" },
      { user: "hasan", amount: "0.00050000 BTC", date: "28.01.2026 16:27" },
      { user: "sleeygoy", amount: "24.00000000 DOGE", date: "28.01.2026 16:23" },
    ];

    function renderLatestTables(){
      const depBody = document.getElementById("latestDeposits");
      const witBody = document.getElementById("latestWithdrawals");
      if (depBody) {
        depBody.innerHTML = "";
        for (const r of latestDepositsData) {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td class="latestUser">${r.user}</td>
            <td class="latestAmount">${r.amount}</td>
            <td>${r.date}</td>
          `;
          depBody.appendChild(tr);
        }
      }

      if (witBody) {
        witBody.innerHTML = "";
        for (const r of latestWithdrawalsData) {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td class="latestUser">${r.user}</td>
            <td class="latestAmount">${r.amount}</td>
            <td>${r.date}</td>
          `;
          witBody.appendChild(tr);
        }
      }
    }

    // ===== Testimonials grid (random 4 by 4) =====
    const testimonialData = [
      {
        quote: "Reliable payouts and clear analytics. The profit simulator matches our live results almost perfectly.",
        name: "Lila Gardner",
        role: "Mining operations lead",
        avatar: "img/avatar/12.jpg",
      },
      {
        quote: "Setup was instant, and the UI makes it easy to forecast every dollar. Our team trusts the insights.",
        name: "Oscar Briggs",
        role: "Portfolio strategist",
        avatar: "img/avatar/23.jpg",
      },
      {
        quote: "The profitability ladder helps our clients pick the right plan. Support responds fast and stays on top.",
        name: "Priya Nair",
        role: "Client success manager",
        avatar: "img/avatar/34.jpg",
      },
      {
        quote: "We’ve seen steady growth every month. The dashboard keeps our investors confident.",
        name: "Mateo Ruiz",
        role: "Growth analyst",
        avatar: "img/avatar/46.png",
      },
      {
        quote: "Instant insights into daily yield made our onboarding smoother than any other platform.",
        name: "Claire Okafor",
        role: "Operations director",
        avatar: "img/avatar/7.jpg",
      },
      {
        quote: "Predictive ROI with real-time updates is exactly what our treasury team needed.",
        name: "Jordan Wells",
        role: "Treasury manager",
        avatar: "img/avatar/18.jpg",
      },
      {
        quote: "The dashboard is clean, fast, and the metrics are spot-on for our mining pools.",
        name: "Dimitri Koval",
        role: "Pool coordinator",
        avatar: "img/avatar/29.jpg",
      },
      {
        quote: "We trust the payout schedule because the transparency is better than any exchange.",
        name: "Naomi Kim",
        role: "Risk analyst",
        avatar: "img/avatar/41.jpg",
      },
      {
        quote: "The profitability view keeps our investors aligned and reduces support tickets.",
        name: "Sofia Mendes",
        role: "Investor relations",
        avatar: "img/avatar/50.jpg",
      },
      {
        quote: "Onboarding large clients is now a breeze thanks to the simple projections.",
        name: "Ethan Pierce",
        role: "Enterprise sales",
        avatar: "img/avatar/59.jpg",
      },
      {
        quote: "We can model revenue scenarios in seconds and instantly share updates with our team.",
        name: "Aria Patel",
        role: "Finance lead",
        avatar: "img/avatar/3.jpg",
      },
      {
        quote: "The weekly breakdown and alerts help us stay ahead of market swings.",
        name: "Marcos Silva",
        role: "Growth strategist",
        avatar: "img/avatar/15.jpg",
      },
    ];

    function initTestimonials(){
      const grid = document.getElementById("testimonialGrid");
      if (!grid) return;

      const buttons = Array.from(document.querySelectorAll(".testimonialBtn"));
      const prefersReduced = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
      let timer = null;

      const starHTML = `
        <div class="testimonialStars" aria-label="5 out of 5 stars">
          <i class="fa-solid fa-star" aria-hidden="true"></i>
          <i class="fa-solid fa-star" aria-hidden="true"></i>
          <i class="fa-solid fa-star" aria-hidden="true"></i>
          <i class="fa-solid fa-star" aria-hidden="true"></i>
          <i class="fa-solid fa-star" aria-hidden="true"></i>
        </div>
      `;

      function shuffle(list){
        const copy = [...list];
        for (let i = copy.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [copy[i], copy[j]] = [copy[j], copy[i]];
        }
        return copy;
      }

      function renderSet(){
        const selection = shuffle(testimonialData).slice(0, 4);
        grid.innerHTML = "";
        selection.forEach((item, index) => {
          const card = document.createElement("article");
          card.className = "testimonialCard";
          card.setAttribute("aria-label", `Testimonial ${index + 1} of 4`);
          card.innerHTML = `
            ${starHTML}
            <p class="testimonialQuote">“${item.quote}”</p>
            <div class="testimonialPerson">
              <img class="testimonialAvatar" src="${item.avatar}" alt="Client avatar of ${item.name}" loading="lazy" decoding="async" />
              <div>
                <div class="testimonialName">${item.name}</div>
                <div class="testimonialRole">${item.role}</div>
              </div>
            </div>
          `;
          grid.appendChild(card);
        });
      }

      function stopTimer(){
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      function startTimer(){
        if (prefersReduced) return;
        stopTimer();
        timer = setInterval(renderSet, 7000);
      }

      function restartTimer(){
        stopTimer();
        startTimer();
      }

      buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
          renderSet();
          restartTimer();
        });
      });

      grid.addEventListener("mouseenter", stopTimer);
      grid.addEventListener("mouseleave", startTimer);
      grid.addEventListener("focusin", stopTimer);
      grid.addEventListener("focusout", startTimer);

      renderSet();
      startTimer();
    }

    // ===== Demo calculator (replace with your logic) =====
    const COIN_USD = {
      BTC: 89500,
      ETH: 2400,
      USDT: 1,
      BNB: 320,
      XRP: 0.55,
      USDC: 1,
      SOL: 100,
      STETH: 2400,
      TRX: 0.12,
      DOGE: 0.16,
      ADA: 0.50,
      BCH: 420,
      WBTC: 89500,
      WBETH: 2400,
      WEETH: 2400,
      WETH: 2400,
      WSTETH: 2400,
      USDS: 1,
      "BSC-USD": 1,
      XMR: 160,
      LEO: 6,
      LINK: 15,
      HYPE: 1,
      CBBTC: 89500,
      XLM: 0.12,
      USDE: 1,
      ZEC: 30,
      CC: 1,
      LTC: 110,
      SUI: 1.2,
      AVAX: 35,
      USD1: 1,
      SHIB: 0.00001,
      HBAR: 0.08,
      WLFI: 1,
      USDT0: 1,
      DAI: 1,
      SUSDS: 1,
      PYUSD: 1,
      SUSDE: 1,
      TON: 2.5,
      CRO: 0.12,
      RAIN: 1,
      DOT: 6.5,
      UNI: 7,
      MNT: 1.1,
      XAUT: 2000,
      WBT: 20,
      M: 0.01,
      FIGR_HELOC: 1,
    }; // demo prices (swap with real API)

    const COIN_DECIMALS = {
      BTC: 8,
      ETH: 8,
      USDT: 6,
      BNB: 8,
      XRP: 6,
      USDC: 6,
      SOL: 8,
      STETH: 8,
      TRX: 4,
      DOGE: 4,
      ADA: 6,
      BCH: 8,
      WBTC: 8,
      WBETH: 8,
      WEETH: 8,
      WETH: 8,
      WSTETH: 8,
      USDS: 6,
      "BSC-USD": 6,
      XMR: 8,
      LEO: 6,
      LINK: 8,
      HYPE: 6,
      CBBTC: 8,
      XLM: 6,
      USDE: 6,
      ZEC: 8,
      CC: 6,
      LTC: 8,
      SUI: 6,
      AVAX: 8,
      USD1: 6,
      SHIB: 0,
      HBAR: 6,
      WLFI: 6,
      USDT0: 6,
      DAI: 6,
      SUSDS: 6,
      PYUSD: 6,
      SUSDE: 6,
      TON: 6,
      CRO: 6,
      RAIN: 6,
      DOT: 8,
      UNI: 8,
      MNT: 6,
      XAUT: 6,
      WBT: 6,
      M: 6,
      FIGR_HELOC: 6,
    };

    function recalc(){
      const amount = parseFloat(String(els.amountInput.value).replace(/,/g,'')) || 0;
      const days = Math.max(0, Math.min(365, parseInt(String(els.daysInput.value).replace(/[^0-9]/g, ''), 10) || 0));
      const stepIndex = computeProfitIndex(amount, days);
      selectedProfitIndex = stepIndex;
      const dailyPct = profitabilitySteps[stepIndex] / 100;
      updateProfitBubbles();

      // mock hashrate to look similar visually
      const hashrate = Math.max(0, amount / 3.44);
      els.hashrate.textContent = formatNum(hashrate, 2);

      // fake profitability numbers (demo)
      const dailyBtc = (hashrate * dailyPct) / 70000;
      const hourlyBtc = dailyBtc / 24;
      const weeklyBtc = dailyBtc * 7;
      const monthlyBtc = dailyBtc * 31;
      const annualBtc = dailyBtc * 365;

      const coin = String(selectedMiningTicker || "BTC").toUpperCase();
      const dec = COIN_DECIMALS[coin] ?? 8;
      const coinUsd = COIN_USD[coin] ?? 1;

      const toCoinStr = (v) => `${v.toFixed(dec)} ${coin.toLowerCase()}.`;
      const toUsdStr = (v) => "≈ $" + (v * coinUsd).toFixed(4);

      els.hourlyBtc.textContent = toCoinStr(hourlyBtc);
      els.dailyBtc.textContent = toCoinStr(dailyBtc);
      els.weeklyBtc.textContent = toCoinStr(weeklyBtc);
      els.monthlyBtc.textContent = toCoinStr(monthlyBtc);
      els.annualBtc.textContent = toCoinStr(annualBtc);

      els.hourlyUsd.textContent = toUsdStr(hourlyBtc);
      els.dailyUsd.textContent = toUsdStr(dailyBtc);
      els.weeklyUsd.textContent = toUsdStr(weeklyBtc);
      els.monthlyUsd.textContent = toUsdStr(monthlyBtc);
      els.annualUsd.textContent = toUsdStr(annualBtc);

      els.pricePerTh.textContent = "$1";
    }

    // ===== Wire up inputs =====
    els.amountRange.addEventListener('input', () => {
      els.amountInput.value = Number(els.amountRange.value).toFixed(2);
      recalc();
    });

    els.amountInput.addEventListener('input', () => {
      const v = parseFloat(String(els.amountInput.value).replace(/,/g,'')) || 0;
      els.amountRange.value = Math.max(0, Math.min(20000, v));
      recalc();
    });

    els.daysRange.addEventListener('input', () => {
      els.daysInput.value = els.daysRange.value;
      recalc();
    });

    els.daysInput.addEventListener('input', () => {
      const v = parseInt(String(els.daysInput.value).replace(/[^0-9]/g, ''), 10) || 0;
      els.daysRange.value = Math.max(0, Math.min(365, v));
      recalc();
    });

    // ===== Dropdown open/close =====
    function toggleWrap(wrap, btn){
      const open = wrap.classList.toggle("open");
      btn.setAttribute("aria-expanded", open ? "true" : "false");
    }

    els.icBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      toggleWrap(els.icWrap, els.icBtn);
      els.mcWrap.classList.remove("open");
      els.mcBtn.setAttribute("aria-expanded", "false");
    });

    els.mcBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      toggleWrap(els.mcWrap, els.mcBtn);
      els.icWrap.classList.remove("open");
      els.icBtn.setAttribute("aria-expanded", "false");
    });

    document.addEventListener("click", () => {
      els.icWrap.classList.remove("open");
      els.icBtn.setAttribute("aria-expanded", "false");
      els.mcWrap.classList.remove("open");
      els.mcBtn.setAttribute("aria-expanded", "false");
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        els.icWrap.classList.remove("open");
        els.icBtn.setAttribute("aria-expanded", "false");
        els.mcWrap.classList.remove("open");
        els.mcBtn.setAttribute("aria-expanded", "false");
      }
    });

    // keep pill position correct on resize
    window.addEventListener('resize', updateProfitBubbles);

    // ===== init =====
    buildProfitBubbles();
    initInvestment();
    initMining();
    recalc();
    renderMarketingTables();
    renderLatestTables();
    initTestimonials();

    // ===== Affiliate canvas animation: steps 1-3 =====
    function initAffiliateCanvas(){
      const graph = document.querySelector(".affGraph");
      const canvas = document.getElementById("affCanvas");
      const steps = Array.from(document.querySelectorAll(".affStep"));
      if (!graph || !canvas || steps.length < 3) return;

      const ctx = canvas.getContext("2d");
      if (!ctx) return;

      let points = [];
      let width = 0;
      let height = 0;
      let rafId = 0;
      const prefersReduced = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;

      function syncPoints(){
        const rect = graph.getBoundingClientRect();
        width = Math.max(1, rect.width);
        height = Math.max(1, rect.height);
        const dpr = window.devicePixelRatio || 1;

        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        points = steps.map((step) => {
          const badge = step.querySelector(".affStepBadge");
          const bRect = (badge || step).getBoundingClientRect();
          return {
            x: bRect.left - rect.left + bRect.width / 2,
            y: bRect.top - rect.top + bRect.height / 2,
            r: bRect.width / 2,
          };
        });
      }

      function drawCurve(time){
        ctx.clearRect(0, 0, width, height);
        if (points.length < 2) return;

        const gradient = ctx.createLinearGradient(points[0].x, points[0].y, points[points.length - 1].x, points[points.length - 1].y);
        gradient.addColorStop(0, "rgba(184,254,8,0.25)");
        gradient.addColorStop(0.5, "rgba(184,254,8,0.9)");
        gradient.addColorStop(1, "rgba(184,254,8,0.05)");

        ctx.save();
        ctx.lineCap = "round";
        ctx.lineJoin = "round";

        const dashOffset = prefersReduced ? 0 : -(time * 0.06);
        ctx.strokeStyle = "rgba(184,254,8,0.15)";
        ctx.lineWidth = 8;
        ctx.setLineDash([]);
        drawSmoothPath(points);
        ctx.stroke();

        ctx.strokeStyle = gradient;
        ctx.lineWidth = 2.2;
        ctx.setLineDash([22, 14]);
        ctx.lineDashOffset = dashOffset;
        drawSmoothPath(points);
        ctx.stroke();

        if (!prefersReduced) {
          points.forEach((pt, idx) => {
            const pulse = (Math.sin(time / 400 + idx) + 1) * 0.5;
            ctx.beginPath();
            ctx.arc(pt.x, pt.y, pt.r + 12 + pulse * 6, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(184,254,8,${0.08 + pulse * 0.08})`;
            ctx.lineWidth = 2;
            ctx.stroke();
          });
        }

        ctx.restore();
      }

      function drawSmoothPath(pts){
        ctx.beginPath();
        ctx.moveTo(pts[0].x, pts[0].y);
        for (let i = 0; i < pts.length - 1; i++) {
          const p1 = pts[i];
          const p2 = pts[i + 1];
          const midX = (p1.x + p2.x) / 2;
          const midY = (p1.y + p2.y) / 2;
          ctx.quadraticCurveTo(p1.x, p1.y, midX, midY);
        }
        const last = pts[pts.length - 1];
        ctx.lineTo(last.x, last.y);
      }

      function animate(time){
        drawCurve(time);
        if (!prefersReduced) {
          rafId = window.requestAnimationFrame(animate);
        }
      }

      function handleResize(){
        syncPoints();
        drawCurve(performance.now());
      }

      syncPoints();
      drawCurve(performance.now());
      if (!prefersReduced) {
        rafId = window.requestAnimationFrame(animate);
      }

      window.addEventListener("resize", handleResize, { passive: true });
      window.addEventListener("orientationchange", handleResize, { passive: true });

      return () => {
        window.cancelAnimationFrame(rafId);
        window.removeEventListener("resize", handleResize);
        window.removeEventListener("orientationchange", handleResize);
      };
    }

    initAffiliateCanvas();

    function initDailyUserAvatars(){
      const avatars = Array.from(document.querySelectorAll(".userChip .avatar"));
      if (!avatars.length) return;

      const total = 65;
      const indices = Array.from({ length: total }, (_, i) => i + 1);

      function shuffle(list){
        for (let i = list.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [list[i], list[j]] = [list[j], list[i]];
        }
        return list;
      }

      function applyAvatars(){
        const pool = shuffle([...indices]);
        avatars.forEach((avatar, idx) => {
          const number = pool[idx % pool.length];
          avatar.style.backgroundImage = `url("img/avatar/${number}.jpg")`;
        });
      }

      applyAvatars();
      window.setInterval(applyAvatars, 60 * 60 * 1000);
    }

    initDailyUserAvatars();
  </script>
</body>
</html>
