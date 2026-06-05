<?php
/**
 * MPS - MEUDJIEM PRESTATION & SERVICES 
 * VERSION STANDALONE V4.1 - LOGO EMBARQUÉ + AUTO-REPAIR
 */

// --- CONFIGURATION ---
$admin_password = "admin123"; 
$whatsapp_number = "33759083580";

// --- GESTION DES DONNÉES (AUTO-REPAIR) ---
$db_file = 'mps_data.json';
if (!file_exists($db_file)) {
    $initial_data = [
        "dossiers" => ["MPS-2024-EX" => ["nom" => "Client Exemple", "statut" => "Dossier en attente", "progression" => 10]],
        "blog" => [
            ["id" => 1, "titre" => "Réforme de l'immigration 2024", "date" => "2024-05-25", "image" => "https://images.unsplash.com/photo-1589216532372-1c2a367900d9?auto=format&fit=crop&w=600&q=80", "extrait" => "Découvrez les derniers changements sur les titres de séjour."],
            ["id" => 2, "titre" => "Crédit d'impôt de 50%", "date" => "2024-05-28", "image" => "https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=600&q=80", "extrait" => "Comment économiser sur vos services à domicile."]
        ]
    ];
    file_put_contents($db_file, json_encode($initial_data));
}
$data = json_decode(file_get_contents($db_file), true);

// LOGIQUE ADMIN
if (isset($_POST['admin_action']) && $_POST['pass'] == $admin_password) {
    if ($_POST['admin_action'] == 'add_dossier') {
        $data['dossiers'][$_POST['d_id']] = ["nom" => $_POST['d_nom'], "statut" => $_POST['d_statut'], "progression" => $_POST['d_prog']];
    }
    if ($_POST['admin_action'] == 'add_article') {
        $data['blog'][] = ["id" => time(), "titre" => $_POST['b_titre'], "date" => date('Y-m-d'), "image" => $_POST['b_img'], "extrait" => $_POST['b_extrait']];
    }
    file_put_contents($db_file, json_encode($data));
}

$view = $_GET['view'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPS - Meudjiem Prestation & Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root { --mps-blue: #1e3a8a; --mps-red: #dc2626; }
        .hero-animate { background: linear-gradient(-45deg, #0f172a, #1e3a8a, #0f172a); background-size: 400% 400%; animation: grad 15s ease infinite; }
        @keyframes grad { 0% {background-position: 0% 50%;} 50% {background-position: 100% 50%;} 100% {background-position: 0% 50%;} }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <!-- Navigation -->
    <nav class="glass fixed top-0 w-full z-[100] border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <!-- LOGO TEXTUEL DE SECOURS SI IMAGE ABSENTE -->
                <div class="bg-mps-blue text-white p-2 rounded-lg font-black text-xl">M<span class="text-red-600">P</span>S</div>
                <div class="hidden md:block">
                    <span class="block font-black text-mps-blue uppercase leading-none">Meudjiem Prestation</span>
                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Services & Administration</span>
                </div>
            </a>
            <div class="flex gap-6 font-bold text-xs uppercase tracking-widest">
                <a href="#services" class="hover:text-mps-red transition">Services</a>
                <a href="#tracking" class="bg-mps-blue text-white px-4 py-2 rounded-lg shadow-lg">Suivi Dossier</a>
            </div>
        </div>
    </nav>

    <?php if ($view == 'home'): ?>
        <!-- Hero -->
        <section class="hero-animate pt-44 pb-32 px-4 text-white">
            <div class="max-w-7xl mx-auto text-center" data-aos="zoom-in">
                <h2 class="text-5xl md:text-7xl font-black mb-8 leading-tight italic">Information & <span class="text-red-600">Orientation</span></h2>
                <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto">Confidentialité & Discrétion assurées pour toutes vos démarches administratives en France et au Cameroun.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://wa.me/<?php echo $whatsapp_number; ?>" class="px-8 py-4 bg-red-600 rounded-2xl font-black hover:scale-105 transition shadow-2xl">Contact WhatsApp</a>
                    <a href="#services" class="px-8 py-4 border border-white/20 rounded-2xl font-black hover:bg-white/10 transition">Nos Services</a>
                </div>
            </div>
        </section>

        <!-- Grille de Services -->
        <section id="services" class="py-24 max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up">
                <i class="fas fa-id-card text-3xl text-red-600 mb-6"></i>
                <h3 class="text-xl font-bold mb-4 italic">Titres de Séjour</h3>
                <p class="text-slate-500 text-sm">Demande, renouvellement et préparation de dossier préfecture.</p>
            </div>
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-passport text-3xl text-mps-blue mb-6"></i>
                <h3 class="text-xl font-bold mb-4 italic">Visas & Passeports</h3>
                <p class="text-slate-500 text-sm">Formalités en ligne pour le Cameroun et l'international.</p>
            </div>
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-broom text-3xl text-green-600 mb-6"></i>
                <h3 class="text-xl font-bold mb-4 italic">Services à la Personne</h3>
                <p class="text-slate-500 text-sm">Ménage, courses, repassage. 50% de crédit d'impôt.</p>
            </div>
        </section>

        <!-- Blog -->
        <section id="blog" class="py-24 bg-slate-100 px-4 italic">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-black mb-12 italic text-center uppercase">Actualités Stratégiques</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <?php foreach(array_reverse($data['blog']) as $post): ?>
                    <article class="bg-white rounded-3xl overflow-hidden flex flex-col md:flex-row shadow-sm hover:shadow-xl transition duration-500">
                        <img src="<?php echo $post['image']; ?>" class="w-full md:w-48 h-48 object-cover">
                        <div class="p-8">
                            <h4 class="font-black text-xl mb-2"><?php echo $post['titre']; ?></h4>
                            <p class="text-slate-500 text-sm mb-4"><?php echo $post['extrait']; ?></p>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-widest"><?php echo $post['date']; ?></span>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Tracking -->
        <section id="tracking" class="py-24 max-w-4xl mx-auto px-4 italic">
            <div class="bg-mps-blue rounded-[3rem] p-12 text-white shadow-2xl text-center">
                <h3 class="text-3xl font-black mb-6 italic">Suivi de votre Dossier</h3>
                <form action="index.php#tracking" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="track_id" placeholder="Code Dossier" class="flex-1 bg-white/10 border border-white/20 rounded-xl px-6 py-4 outline-none focus:bg-white/20">
                    <button class="bg-red-600 px-10 py-4 rounded-xl font-black hover:bg-red-700 transition">Vérifier</button>
                </form>
                <?php if (isset($_GET['track_id'])): 
                    $tid = strtoupper($_GET['track_id']);
                    if (isset($data['dossiers'][$tid])): $res = $data['dossiers'][$tid]; ?>
                    <div class="mt-10 p-6 bg-white/5 border border-white/10 rounded-2xl text-left">
                        <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Client: <?php echo $res['nom']; ?></p>
                        <h4 class="text-2xl font-black mt-2"><?php echo $res['statut']; ?></h4>
                        <div class="w-full bg-white/10 h-2 rounded-full mt-4 overflow-hidden">
                            <div class="bg-red-600 h-full transition-all duration-1000" style="width: <?php echo $res['progression']; ?>%"></div>
                        </div>
                    </div>
                <?php endif; endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-slate-100 px-4 italic">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">&copy; <?php echo date('Y'); ?> MEUDJIEM PRESTATION & SERVICES</p>
            <div class="flex gap-6 text-[10px] font-black uppercase tracking-widest">
                <a href="index.php?view=legals" class="hover:text-red-600">Mentions Légales</a>
                <a href="index.php?view=privacy" class="hover:text-red-600">Confidentialité</a>
            </div>
            <p class="text-mps-blue font-black tracking-tighter italic">07 59 08 35 80</p>
        </div>
    </footer>

    <!-- ADMIN -->
    <div class="bg-slate-200 py-10 px-4 text-center">
        <p class="text-[10px] font-bold text-slate-500 mb-6 uppercase tracking-[0.4em]">Administration MPS</p>
        <form action="index.php" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-inner grid grid-cols-1 gap-3">
            <input type="hidden" name="admin_action" value="add_dossier">
            <input type="text" name="d_id" placeholder="ID Dossier" class="border p-2 rounded text-xs">
            <input type="text" name="d_nom" placeholder="Nom" class="border p-2 rounded text-xs">
            <input type="text" name="d_statut" placeholder="Statut" class="border p-2 rounded text-xs">
            <input type="number" name="d_prog" placeholder="%" class="border p-2 rounded text-xs">
            <input type="password" name="pass" placeholder="Password" class="border p-2 rounded text-xs">
            <button class="bg-mps-blue text-white p-2 rounded text-xs font-bold">Mettre à jour</button>
        </form>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({duration: 1000, once: true});</script>
</body>
</html>
