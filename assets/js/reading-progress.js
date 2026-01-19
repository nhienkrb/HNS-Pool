(() => {
  if (typeof storymgrProgress === "undefined") return;

  const cfg = storymgrProgress;
  let lastMilestone = 0;
  let lastSentAt = 0;
  let ticking = false;

  const clamp = (val, min, max) => Math.max(min, Math.min(max, val));

  const getPercent = () => {
    const doc = document.documentElement;
    const body = document.body;
    const scrollTop = window.pageYOffset || doc.scrollTop || body.scrollTop || 0;
    const viewport = window.innerHeight || doc.clientHeight || 0;
    const full = Math.max(doc.scrollHeight, body.scrollHeight, doc.offsetHeight, body.offsetHeight);
    if (full <= 0) return 0;
    const raw = ((scrollTop + viewport) / full) * 100;
    return Math.floor(clamp(raw, 0, 100));
  };

  const getMilestone = (percent) => {
    if (percent >= 100) return 100;
    if (percent >= 75) return 75;
    if (percent >= 50) return 50;
    if (percent >= 25) return 25;
    return 0;
  };

  const sendProgress = (percent) => {
    const now = Date.now();
    const milestone = getMilestone(percent);
    if (milestone <= lastMilestone) return;
    if (now - lastSentAt < 2000 && percent < 100) return;

    lastSentAt = now;
    lastMilestone = milestone;

    const payload = new URLSearchParams();
    payload.set("action", "storymgr_update_progress");
    payload.set("nonce", cfg.nonce);
    payload.set("chapter_id", String(cfg.chapterId));
    payload.set("percent", String(milestone));

    fetch(cfg.ajaxUrl, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: payload.toString(),
    }).catch(() => {});
  };

  const onScroll = () => {
    if (ticking) return;
    ticking = true;
    window.requestAnimationFrame(() => {
      ticking = false;
      sendProgress(getPercent());
    });
  };

  window.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("load", onScroll);
})();
