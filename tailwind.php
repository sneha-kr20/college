<!-- tailwind.php -->
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: { 
        collegeblue: '#004080',
        golden: '#b79613ff'
      },
      fontFamily: { 
        sans: ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif'] 
      },
      boxShadow: {
        soft: '0 6px 20px rgba(0,0,0,0.08)',
        glow: '0 0 25px rgba(0, 64, 128, 0.3)'
      },
    }
  }
}
</script>

<style>
/* 🌈 Animated Gradient Background */
html, body {
  min-height: 100%;
  overflow-x: hidden;
}
body {
  background: linear-gradient(135deg, #f8fafc, #e0f2fe, #fef9c3);
  background-size: 300% 300%;
  animation: gradientShift 12s ease infinite;
}
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* 🪶 Floating, Zoom, Fade Animations */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
.animate-float { animation: float 3s ease-in-out infinite; }

@keyframes zoom-pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}
.animate-zoom-pulse { animation: zoom-pulse 3s ease-in-out infinite; }

@keyframes fade-in {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 1.2s ease-out forwards; }

/* 🧊 Universal Glass Card Design */
.glass-card {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(18px);
  border: 1px solid rgba(255, 255, 255, 0.35);
  transition: all 0.3s ease;
}
.glass-card:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* 🌟 Universal Heading Style with Animations */
.page-heading {
  position: relative;
  text-align: center;
  font-size: clamp(2rem, 5vw, 2.8rem);
  font-weight: 800;
  color: var(--collegeblue, #004080);
  margin-bottom: 2.5rem;
  letter-spacing: -0.02em;
  z-index: 10;
  opacity: 0;
  transform: translateY(30px);
  animation: heading-fade-in 1.2s ease-out forwards;
  animation-delay: 0.2s;
}

.page-heading::after {
  content: "";
  display: block;
  height: 4px;
  width: 80px;
  margin: 0.75rem auto 0;
  background: linear-gradient(to right, #004080, #2563eb, #facc15);
  border-radius: 9999px;
  transition: width 0.5s ease;
}
.page-heading:hover::after {
  width: 140px;
}

/* Glow Effect */
.page-heading-glow::before {
  content: "";
  position: absolute;
  inset: 0;
  margin: auto;
  width: 16rem;
  height: 16rem;
  background: linear-gradient(
    to right,
    rgba(59,130,246,0.15),
    rgba(250,204,21,0.15),
    rgba(236,72,153,0.15)
  );
  filter: blur(80px);
  border-radius: 9999px;
  z-index: 0;
  opacity: 0;
  animation: glow-fade-in 1.5s ease-out forwards;
  animation-delay: 0.5s;
}

/* 🔹 Heading Animations */
@keyframes heading-fade-in {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}

@keyframes glow-fade-in {
  0% { opacity: 0; transform: scale(0.8); }
  100% { opacity: 1; transform: scale(1); }
}

/* 💎 Buttons (Add / Delete / Submit) */
.btn-primary {
  background: linear-gradient(to right, #004080, #2563eb);
  color: white;
  font-weight: 600;
  padding: 0.65rem 1.5rem;
  border-radius: 9999px;
  box-shadow: 0 4px 10px rgba(0,64,128,0.25);
  transition: all 0.3s ease;
}
.btn-primary:hover {
  transform: translateY(-2px) scale(1.03);
  background: linear-gradient(to right, #003366, #1e40af);
  box-shadow: 0 8px 20px rgba(0,64,128,0.35);
}

.btn-danger {
  background: linear-gradient(to right, #ef4444, #dc2626);
  color: white;
  font-weight: 600;
  padding: 0.65rem 1.5rem;
  border-radius: 9999px;
  transition: all 0.3s ease;
}
.btn-danger:hover {
  background: linear-gradient(to right, #b91c1c, #991b1b);
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(239,68,68,0.3);
}

/* 📱 Layout Utility */
.page-container {
  max-width: 72rem;
  margin: 0 auto;
  padding: 3rem 1rem;
}

/* 🏫 Logo + College Name Animations */
.logo-animate {
  animation: logo-float 3s ease-in-out infinite, logo-glow-pulse 2s ease-in-out infinite;
}

@keyframes logo-float {
  0%, 100% { transform: translateY(0) scale(1); }
  50% { transform: translateY(-5px) scale(1.05); }
}

@keyframes logo-glow-pulse {
  0%, 100% { filter: drop-shadow(0 0 0 rgba(0,64,128,0)); }
  50% { filter: drop-shadow(0 0 15px rgba(0,64,128,0.5)); }
}

/* 🏷 College Name */
.college-name-animate {
  opacity: 0;
  transform: translateY(30px);
  animation: name-fade-in 1s ease-out forwards;
  animation-delay: 0.3s;
}

@keyframes name-fade-in {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* 📱 Add Button Responsiveness */
.add-btn-desktop { display: none; }
.add-btn-mobile { display: flex; position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 50; }
@media (min-width: 640px) { 
  .add-btn-desktop { display: inline-flex; }
  .add-btn-mobile { display: none; }
}

/* 📱 Mobile Nav Scroll */
.mobile-nav-scroll {
  display: flex;
  overflow-x: auto;
  gap: 1rem;
  padding-bottom: 0.5rem;
  scrollbar-width: thin;
  -webkit-overflow-scrolling: touch;
}
.mobile-nav-scroll::-webkit-scrollbar { height: 6px; }
.mobile-nav-scroll::-webkit-scrollbar-thumb { background: #004080; border-radius: 9999px; }
.mobile-nav-scroll::-webkit-scrollbar-track { background: #e0f2fe; border-radius: 9999px; }

</style>
