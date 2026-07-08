/**
 * Hero canvas network — drifting nodes connected by proximity lines.
 * Skipped under prefers-reduced-motion and on narrow screens (< 640px).
 * DPR capped at 2. Pauses when tab is hidden.
 */
(function () {
    const canvas = document.getElementById('hero-bg');
    if (!canvas) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.innerWidth < 640) return;

    const ctx = canvas.getContext('2d');

    const NODE_COUNT = 42;
    const MAX_DIST   = 170;
    const MAX_SPEED  = 0.38;
    const COLORS     = ['#7C3AED', '#EC1FC4', '#2E8BE6'];

    let nodes  = [];
    let mouse  = { x: -9999, y: -9999 };
    let rafId  = null;
    let W      = 0;
    let H      = 0;

    function resize() {
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        W = canvas.offsetWidth;
        H = canvas.offsetHeight;
        canvas.width  = W * dpr;
        canvas.height = H * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function makeNode() {
        return {
            x:     Math.random() * W,
            y:     Math.random() * H,
            vx:    (Math.random() - 0.5) * MAX_SPEED,
            vy:    (Math.random() - 0.5) * MAX_SPEED,
            r:     Math.random() * 2 + 1.5,
            color: COLORS[Math.floor(Math.random() * COLORS.length)],
        };
    }

    function initNodes() {
        nodes = Array.from({ length: NODE_COUNT }, makeNode);
    }

    function clampSpeed(n) {
        const s = Math.sqrt(n.vx * n.vx + n.vy * n.vy);
        if (s > MAX_SPEED) {
            n.vx = (n.vx / s) * MAX_SPEED;
            n.vy = (n.vy / s) * MAX_SPEED;
        }
    }

    function tick() {
        ctx.clearRect(0, 0, W, H);

        for (const n of nodes) {
            // Weak mouse attraction within 130px
            const dx = mouse.x - n.x;
            const dy = mouse.y - n.y;
            const d2 = dx * dx + dy * dy;
            if (d2 < 130 * 130) {
                const d = Math.sqrt(d2);
                n.vx += (dx / d) * 0.012;
                n.vy += (dy / d) * 0.012;
            }

            n.vx *= 0.992;
            n.vy *= 0.992;
            clampSpeed(n);

            n.x += n.vx;
            n.y += n.vy;

            if (n.x < 0)  { n.x = 0;  n.vx *= -1; }
            if (n.x > W)  { n.x = W;  n.vx *= -1; }
            if (n.y < 0)  { n.y = 0;  n.vy *= -1; }
            if (n.y > H)  { n.y = H;  n.vy *= -1; }
        }

        // Draw connecting lines
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const dx = nodes[j].x - nodes[i].x;
                const dy = nodes[j].y - nodes[i].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < MAX_DIST) {
                    ctx.beginPath();
                    ctx.moveTo(nodes[i].x, nodes[i].y);
                    ctx.lineTo(nodes[j].x, nodes[j].y);
                    ctx.strokeStyle = nodes[i].color;
                    ctx.globalAlpha = (1 - dist / MAX_DIST) * 0.14;
                    ctx.lineWidth   = 1;
                    ctx.stroke();
                }
            }
        }

        // Draw nodes
        ctx.globalAlpha = 1;
        for (const n of nodes) {
            ctx.beginPath();
            ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
            ctx.fillStyle   = n.color;
            ctx.globalAlpha = 0.30;
            ctx.fill();
        }
        ctx.globalAlpha = 1;

        rafId = requestAnimationFrame(tick);
    }

    // Pause / resume on tab visibility change
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            cancelAnimationFrame(rafId);
            rafId = null;
        } else if (!rafId) {
            rafId = requestAnimationFrame(tick);
        }
    });

    // Track mouse over the hero section
    const section = canvas.closest('section');
    if (section) {
        section.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });
        section.addEventListener('mouseleave', () => {
            mouse.x = -9999;
            mouse.y = -9999;
        });
    }

    // Re-scatter on resize (avoid nodes bunching at old edges)
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            resize();
            initNodes();
        }, 120);
    });

    resize();
    initNodes();
    rafId = requestAnimationFrame(tick);
})();
