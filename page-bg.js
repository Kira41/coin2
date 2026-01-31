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
