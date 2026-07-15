<?php
/**
 * @var \App\View\AppView $this
 * @var array $stats
 * @var object $currentUser
 * @var array $trendData
 * @var array $letterTypes
 * @var array $recentActivities
 * @var \Cake\ORM\ResultSet $recentRequests
 * @var int $monthsFilter
 */

$userName   = $currentUser->full_name ?? 'Administrator';
$isAdmin    = ($currentUser->role_id == 1);
$sessionKey = 'welcomed_' . ($currentUser->id ?? 'guest');
$showWelcome = !$this->request->getSession()->read($sessionKey);
if ($showWelcome) $this->request->getSession()->write($sessionKey, true);

// CakePHP URL helpers for stat card links
$urlAll      = $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index']);
$urlPending  = $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index', '?' => ['status' => 'Pending']]);
$urlApproved = $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index', '?' => ['status' => 'Approved']]);
$urlRejected = $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index', '?' => ['status' => 'Rejected']]);
$urlAdd      = $this->Url->build(['controller' => 'LetterRequests', 'action' => 'add']);
?>

<?php if ($showWelcome): ?>
<div id="welcome-splash" aria-live="polite" aria-label="Welcome animation">
    <div id="splash-bg"></div>
    <div id="splash-content">
        <div id="splash-ring">
            <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="60" r="54" stroke="rgba(255,255,255,0.12)" stroke-width="2"/>
                <circle id="ring-arc" cx="60" cy="60" r="54" stroke="white" stroke-width="2.5"
                        stroke-dasharray="339.3" stroke-dashoffset="339.3"
                        stroke-linecap="round" transform="rotate(-90 60 60)"/>
                <path id="splash-check" d="M38 61 L53 76 L83 45"
                      stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                      stroke-dasharray="65" stroke-dashoffset="65"/>
            </svg>
        </div>
        <div id="splash-text">
            <div id="splash-greeting">Selamat Datang</div>
            <div id="splash-name"><?= h($userName) ?></div>
            <div id="splash-sub">UiTM e-Letter Portal &bull; <?= $isAdmin ? 'Administrator' : 'Student' ?></div>
        </div>
        <div id="splash-loader"><div id="loader-bar"></div></div>
    </div>
</div>
<style>
#welcome-splash{position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;overflow:hidden}
#splash-bg{position:absolute;inset:0;background:linear-gradient(135deg,#2d0d6b 0%,#4c1d95 45%,#7c3aed 100%)}
#splash-bg::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 25% 65%,rgba(167,139,250,.22) 0%,transparent 58%),radial-gradient(ellipse at 78% 28%,rgba(236,72,153,.13) 0%,transparent 52%);animation:bgPulse 5s ease-in-out infinite alternate}
@keyframes bgPulse{to{transform:scale(1.05)}}
#splash-content{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;gap:24px;text-align:center}
#splash-ring{width:120px;height:120px;opacity:0;transform:scale(.7);animation:ringIn .5s cubic-bezier(.34,1.56,.64,1) .15s forwards}
@keyframes ringIn{to{opacity:1;transform:scale(1)}}
#ring-arc{animation:arcDraw .9s cubic-bezier(.4,0,.2,1) .6s forwards}
@keyframes arcDraw{to{stroke-dashoffset:0}}
#splash-check{animation:checkDraw .4s ease-out 1.38s forwards}
@keyframes checkDraw{to{stroke-dashoffset:0}}
#splash-text{color:#fff;opacity:0;transform:translateY(14px);animation:textUp .55s ease-out .95s forwards}
@keyframes textUp{to{opacity:1;transform:translateY(0)}}
#splash-greeting{font-family:'Segoe UI',system-ui,sans-serif;font-size:13px;font-weight:400;letter-spacing:3.5px;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:5px}
#splash-name{font-family:'Segoe UI',system-ui,sans-serif;font-size:clamp(20px,3.5vw,32px);font-weight:700;letter-spacing:-.3px;text-transform:uppercase;margin-bottom:6px}
#splash-sub{font-size:11px;color:rgba(255,255,255,.38);letter-spacing:2px;text-transform:uppercase}
#splash-loader{width:160px;height:3px;background:rgba(255,255,255,.12);border-radius:99px;overflow:hidden;opacity:0;animation:showLoader .25s ease 1.5s forwards}
#loader-bar{height:100%;width:0;background:#fff;border-radius:99px;animation:fillBar 1.1s cubic-bezier(.4,0,.2,1) 1.6s forwards}
@keyframes showLoader{to{opacity:1}}
@keyframes fillBar{to{width:100%}}
#welcome-splash.fade-out{animation:splashOut .65s cubic-bezier(.4,0,1,1) forwards;pointer-events:none}
@keyframes splashOut{to{opacity:0;transform:scale(1.03)}}
</style>
<script>
(function(){
    var DURATION = 3100;
    window.addEventListener('load', function(){
        setTimeout(function(){
            var s = document.getElementById('welcome-splash');
            if(!s) return;
            s.classList.add('fade-out');
            setTimeout(function(){ s.style.display='none'; triggerDashboard(); }, 650);
        }, DURATION);
    });
    function triggerDashboard(){
        document.querySelectorAll('.sa').forEach(function(el,i){
            el.style.animation = 'cardIn .45s ease-out '+(i*70)+'ms both';
        });
        document.querySelectorAll('.ra').forEach(function(el,i){
            el.style.animation = 'cardIn .45s ease-out '+(i*60+100)+'ms both';
        });
        startCountUp();
    }
    window._splashShown = true;
})();
</script>
<?php endif; ?>

<style>
/* ----- Base ----- */
.db-wrap{padding:22px;background:#f8fafc;min-height:100vh;font-family:'Segoe UI',system-ui,sans-serif}

/* ----- Entrance animations ----- */
@keyframes cardIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.sa,.ra{opacity:0}
<?php if (!$showWelcome): ?>
.sa{animation:cardIn .45s ease-out both}
.ra{animation:cardIn .45s ease-out both}
<?php endif; ?>

/* ----- Stat cards ----- */
.stat-card{
    background:#fff;border-radius:14px;border:none;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04);
    cursor:pointer;transition:transform .2s ease,box-shadow .2s ease;
    text-decoration:none;display:block;color:inherit;position:relative;overflow:hidden
}
.stat-card::after{content:'';position:absolute;inset:0;background:rgba(0,0,0,0);transition:background .2s}
.stat-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,.1);color:inherit;text-decoration:none}
.stat-card:hover::after{background:rgba(0,0,0,.012)}
.stat-card:active{transform:translateY(-1px)}
.stat-card .card-body{padding:18px 20px}
.stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.stat-label{font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:#94a3b8;margin-bottom:4px}
.stat-value{font-size:28px;font-weight:700;line-height:1;margin-bottom:4px;font-variant-numeric:tabular-nums}
.stat-link{font-size:12px;font-weight:500;display:inline-flex;align-items:center;gap:4px;opacity:.75;transition:opacity .15s}
.stat-card:hover .stat-link{opacity:1}

/* Progress bar inside card */
.stat-bar{height:3px;border-radius:99px;margin-top:14px;background:#f1f5f9;overflow:hidden}
.stat-bar-fill{height:100%;border-radius:99px;width:0;transition:width 1s cubic-bezier(.4,0,.2,1)}

/* ----- Chart cards ----- */
.chart-card{background:#fff;border-radius:14px;border:none;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04);padding:22px}
.card-title{font-size:14px;font-weight:700;color:#1e293b;margin-bottom:16px;letter-spacing:-.1px}

/* ----- Timeline ----- */
.tl-item{position:relative;padding:0 0 14px 22px;border-left:2px solid #e2e8f0}
.tl-item::before{content:'';position:absolute;left:-5px;top:5px;width:8px;height:8px;border-radius:50%;background:#4c1d95}
.tl-item:last-child{border-left-color:transparent;padding-bottom:0}

/* ----- Table ----- */
.req-table th{font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;color:#94a3b8;border:none;background:#f8fafc;padding:10px 12px}
.req-table td{padding:12px;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:13px}
.req-table tbody tr{transition:background .15s}
.req-table tbody tr:hover{background:#faf9ff}
.req-table tbody tr:last-child td{border-bottom:none}
.req-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;letter-spacing:.3px}
.pill-approved{background:#dcfce7;color:#15803d}
.pill-rejected{background:#fee2e2;color:#b91c1c}
.pill-pending{background:#fef9c3;color:#a16207}

/* ----- Quick actions ----- */
.qa-btn{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;text-decoration:none;transition:transform .2s,box-shadow .2s}
.qa-btn:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(0,0,0,.12)}

/* ----- Month filter ----- */
.mf-btn{padding:6px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;transition:all .15s}
.mf-active{background:#4c1d95;color:#fff!important;border-color:#4c1d95}
.mf-btn:not(.mf-active){background:#fff;color:#475569}
.mf-btn:not(.mf-active):hover{background:#f8fafc;border-color:#cbd5e1}

/* ----- Scroll animation trigger ----- */
@media (prefers-reduced-motion: reduce){.sa,.ra{opacity:1!important;animation:none!important}}
</style>

<div class="db-wrap">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 ra" style="animation-delay:0ms">
        <div>
            <h4 style="font-weight:700;color:#0f172a;margin-bottom:3px;font-size:20px">
                Welcome back, <?= h($userName) ?> 👋
            </h4>
            <p style="color:#64748b;font-size:13px;margin:0">Here's what's happening with your e-letter system today.</p>
        </div>
        <?php if ($isAdmin): ?>
        <div class="d-flex gap-2 mt-2 mt-sm-0">
            <a href="?months=1" class="mf-btn <?= $monthsFilter==1?'mf-active':'' ?>">1 Month</a>
            <a href="?months=3" class="mf-btn <?= $monthsFilter==3?'mf-active':'' ?>">3 Months</a>
            <a href="?months=6" class="mf-btn <?= $monthsFilter==6?'mf-active':'' ?>">6 Months</a>
        </div>
        <?php endif; ?>
    </div>

    <?php
    $total     = (int)($stats['total']     ?? 0);
    $pending   = (int)($stats['pending']   ?? 0);
    $approved  = (int)($stats['approved']  ?? 0);
    $rejected  = (int)($stats['rejected']  ?? 0);
    $generated = (int)($stats['generated'] ?? 0);
    $safeTotal = $total > 0 ? $total : 1;

    $cards = [
        ['label'=>'Total Requests',    'value'=>$total,     'color'=>'#4c1d95','bg'=>'#ede9fe','icon'=>'fa-file-invoice',  'link'=>'View all',      'url'=>$urlAll,      'pct'=>100,                           'delay'=>0],
        ['label'=>'Pending',           'value'=>$pending,   'color'=>'#d97706','bg'=>'#fef3c7','icon'=>'fa-clock',          'link'=>'Needs action',  'url'=>$urlPending,  'pct'=>round($pending/$safeTotal*100),  'delay'=>70],
        ['label'=>'Approved',          'value'=>$approved,  'color'=>'#15803d','bg'=>'#dcfce7','icon'=>'fa-circle-check',   'link'=>'View approved', 'url'=>$urlApproved, 'pct'=>round($approved/$safeTotal*100), 'delay'=>140],
        ['label'=>'Rejected',          'value'=>$rejected,  'color'=>'#b91c1c','bg'=>'#fee2e2','icon'=>'fa-circle-xmark',   'link'=>'View rejected', 'url'=>$urlRejected, 'pct'=>round($rejected/$safeTotal*100), 'delay'=>210],
        ['label'=>'Generated Letters', 'value'=>$generated, 'color'=>'#0369a1','bg'=>'#e0f2fe','icon'=>'fa-download',       'link'=>'View letters',  'url'=>$urlAll,      'pct'=>round($generated/$safeTotal*100),'delay'=>280],
    ];
    ?>
    <div class="row g-3 mb-4">
        <?php foreach ($cards as $c): ?>
        <div class="col-xl col-md-4 col-6 sa" style="animation-delay:<?= $c['delay'] ?>ms">
            <a href="<?= h($c['url']) ?>" class="stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="stat-label"><?= $c['label'] ?></div>
                            <div class="stat-value count-up" data-target="<?= $c['value'] ?>" style="color:<?= $c['color'] ?>">0</div>
                        </div>
                        <div class="stat-icon" style="background:<?= $c['bg'] ?>;color:<?= $c['color'] ?>">
                            <i class="fa-solid <?= $c['icon'] ?>"></i>
                        </div>
                    </div>
                    <div class="stat-link" style="color:<?= $c['color'] ?>">
                        <?= $c['link'] ?> <i class="fa-solid fa-arrow-right" style="font-size:10px"></i>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill" data-pct="<?= $c['pct'] ?>" style="background:<?= $c['color'] ?>"></div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-xl-5 ra" style="animation-delay:150ms">
            <div class="chart-card h-100">
                <div class="card-title">Requests Overview</div>
                <div style="position:relative;height:250px">
                    <canvas id="requestsOverviewChart"
                        role="img" aria-label="Line chart showing total, approved and pending requests over time">
                        Total, approved and pending request trends.
                    </canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 ra" style="animation-delay:220ms">
            <div class="chart-card h-100">
                <div class="card-title">By Letter Type</div>
                <div class="row align-items-center">
                    <div class="col-6">
                        <div style="position:relative;height:160px">
                            <canvas id="letterStatusDoughnutChart"
                                role="img" aria-label="Doughnut chart of requests grouped by letter type">
                                Requests by letter type.
                            </canvas>
                        </div>
                    </div>
                    <div class="col-6" id="js-type-legends"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 ra" style="animation-delay:290ms">
            <div class="chart-card h-100">
                <div class="card-title">Recent Activity</div>
                <div style="max-height:240px;overflow-y:auto">
                    <?php if (!empty($recentActivities)): ?>
                        <?php foreach ($recentActivities as $act): ?>
                            
                        <div class="tl-item">
                            <div style="font-size:13px;font-weight:600;color:#1e293b">Request #REQ-<?= $act->id ?></div>
                            <div style="font-size:11px;color:#64748b;margin:2px 0">
                                Status →
                                <?php
                                    $s = strtolower($act->status ?? '');
                                    $cls = $s==='approved'?'pill-approved':($s==='rejected'?'pill-rejected':'pill-pending');
                                ?>
                                <span class="req-pill <?= $cls ?>"><?= h($act->status) ?></span>
                            </div>
                            <small style="font-size:10px;color:#94a3b8"><?= $act->created_at ? $act->created_at->timeAgoInWords() : '' ?></small>
                        </div>
                        
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align:center;color:#94a3b8;padding:32px 0;font-size:13px">No recent activity.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-xl-9 ra" style="animation-delay:350ms">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-title" style="margin-bottom:0">Recent Requests</div>
                    <a href="<?= h($urlAll) ?>" class="btn btn-sm d-inline-flex align-items-center gap-1"
                       style="background:#4c1d95;color:#fff;border:none;border-radius:8px;padding:6px 14px;font-size:12px;font-weight:600">
                        View More <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="req-table w-100" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th>Ref No.</th>
                                <th>Student</th>
                                <th>Letter Type</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentRequests) && count($recentRequests) > 0): ?>
                                <?php 
                                $count = 0;
                                foreach ($recentRequests as $request): 
                                    if ($count >= 5) break; // Limits output to maximum 5 items
                                    $count++;
                                ?>
                                <tr>
                                    <td style="font-weight:700;color:#6366f1;font-size:12px">#REQ-<?= $request->id ?></td>
                                    <td style="font-weight:600;color:#1e293b"><?= h($request->user?->full_name ?? 'Student') ?></td>
                                    <td>
                                        <span style="background:#f1f5f9;color:#475569;padding:3px 9px;border-radius:6px;font-size:11px;font-weight:600">
                                            <?= h(mb_strimwidth($request->program_name ?? 'General', 0, 22, '…')) ?>
                                        </span>
                                    </td>
                                    <td style="color:#64748b"><?= h(mb_strimwidth($request->purpose ?? '', 0, 40, '…')) ?></td>
                                    <td>
                                        <?php
                                            $st  = $request->status ?? 'Pending';
                                            $cls = strtolower($st)==='approved'?'pill-approved':(strtolower($st)==='rejected'?'pill-rejected':'pill-pending');
                                        ?>
                                        <span class="req-pill <?= $cls ?>"><?= h($st) ?></span>
                                    </td>
                                    <td style="text-align:center">
                                        <a href="<?= $this->Url->build(['action'=>'view_letter',$request->id]) ?>"
                                           style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;font-size:12px;font-weight:600;color:#4c1d95;text-decoration:none;transition:all .15s"
                                           onmouseover="this.style.background='#ede9fe';this.style.borderColor='#a78bfa'"
                                           onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;font-size:13px">No recent requests found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-3 ra" style="animation-delay:420ms">
            <div class="chart-card h-100">
                <div class="card-title">Quick Actions</div>
                <div class="d-flex flex-column gap-3">

                    <a href="<?= h($urlAdd) ?>" style="display:flex;align-items:center;gap:14px;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;transition:all .2s;color:inherit"
                       onmouseover="this.style.background='#ede9fe';this.style.borderColor='#a78bfa'"
                       onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                        <div class="qa-btn" style="background:#ede9fe;color:#4c1d95;border-radius:12px;width:42px;height:42px;font-size:17px;flex-shrink:0"><i class="fa-solid fa-plus"></i></div>
                        <div><div style="font-size:13px;font-weight:700;color:#1e293b">New Request</div><div style="font-size:11px;color:#64748b">Submit letter request</div></div>
                    </a>

                    <a href="<?= h($urlPending) ?>" style="display:flex;align-items:center;gap:14px;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;transition:all .2s;color:inherit"
                       onmouseover="this.style.background='#fef9c3';this.style.borderColor='#fde047'"
                       onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                        <div class="qa-btn" style="background:#fef9c3;color:#a16207;border-radius:12px;width:42px;height:42px;font-size:17px;flex-shrink:0"><i class="fa-solid fa-clock"></i></div>
                        <div><div style="font-size:13px;font-weight:700;color:#1e293b">Pending Requests</div><div style="font-size:11px;color:#64748b"><?= $pending ?> awaiting action</div></div>
                    </a>

                    <a href="<?= h($urlApproved) ?>" style="display:flex;align-items:center;gap:14px;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;transition:all .2s;color:inherit"
                       onmouseover="this.style.background='#dcfce7';this.style.borderColor='#86efac'"
                       onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                        <div class="qa-btn" style="background:#dcfce7;color:#15803d;border-radius:12px;width:42px;height:42px;font-size:17px;flex-shrink:0"><i class="fa-solid fa-circle-check"></i></div>
                        <div><div style="font-size:13px;font-weight:700;color:#1e293b">Approved Letters</div><div style="font-size:11px;color:#64748b"><?= $approved ?> ready to download</div></div>
                    </a>

                    <?php if ($isAdmin): ?>
                    <a href="<?= h($urlAll) ?>" style="display:flex;align-items:center;gap:14px;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;transition:all .2s;color:inherit"
                       onmouseover="this.style.background='#e0f2fe';this.style.borderColor='#7dd3fc'"
                       onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                        <div class="qa-btn" style="background:#e0f2fe;color:#0369a1;border-radius:12px;width:42px;height:42px;font-size:17px;flex-shrink:0"><i class="fa-solid fa-chart-pie"></i></div>
                        <div><div style="font-size:13px;font-weight:700;color:#1e293b">All Records</div><div style="font-size:11px;color:#64748b">View full report</div></div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    /* ---- Count-up ---- */
    function countUp(el){
        var target = parseInt(el.dataset.target)||0;
        if(target===0){el.textContent='0';return;}
        var dur=1100,start=null;
        (function step(ts){
            if(!start) start=ts;
            var p=Math.min((ts-start)/dur,1);
            var e=1-Math.pow(1-p,3);
            el.textContent=Math.floor(e*target).toLocaleString();
            if(p<1) requestAnimationFrame(step);
            else el.textContent=target.toLocaleString();
        })(performance.now());
    }

    /* ---- Bar fill ---- */
    function fillBars(){
        document.querySelectorAll('.stat-bar-fill').forEach(function(b){
            b.style.width=(b.dataset.pct||0)+'%';
        });
    }

    function startCountUp(){
        document.querySelectorAll('.count-up').forEach(countUp);
        fillBars();
    }

    <?php if ($showWelcome): ?>
    window.startCountUp = startCountUp;
    setTimeout(startCountUp, 3750);
    <?php else: ?>
    startCountUp();
    /* Trigger card animations immediately if no splash */
    document.querySelectorAll('.sa').forEach(function(el,i){
        el.style.animation='cardIn .45s ease-out '+(i*70)+'ms both';
    });
    document.querySelectorAll('.ra').forEach(function(el,i){
        el.style.animation='cardIn .45s ease-out '+(i*80+50)+'ms both';
    });
    <?php endif; ?>

    /* ---- Charts ---- */
    const trendRaw = <?= json_encode($trendData) ?>;
    const typesRaw = <?= json_encode($letterTypes) ?>;

    var labelsLine=['May 1','May 7','May 14','May 21','May 28','Jun 4','Jun 11'];
    var dataTotal=[0,0,0,0,0,0,0],dataApproved=[0,0,0,0,0,0,0],dataPending=[0,0,0,0,0,0,0];
    if(trendRaw&&trendRaw.length>0){
        labelsLine   = trendRaw.map(function(i){return i.date;});
        dataTotal    = trendRaw.map(function(i){return parseInt(i.total)||0;});
        dataApproved = trendRaw.map(function(i){return parseInt(i.approved)||0;});
        dataPending  = trendRaw.map(function(i){return parseInt(i.pending)||0;});
    }

    new Chart(document.getElementById('requestsOverviewChart').getContext('2d'),{
        type:'line',
        data:{
            labels:labelsLine,
            datasets:[
                {label:'Total',   data:dataTotal,    borderColor:'#8b5cf6',backgroundColor:'rgba(139,92,246,.07)',fill:true,tension:.4,borderWidth:2,pointRadius:3,pointHoverRadius:5},
                {label:'Approved',data:dataApproved, borderColor:'#10b981',backgroundColor:'rgba(16,185,129,.07)',fill:true,tension:.4,borderWidth:2,pointRadius:3,pointHoverRadius:5},
                {label:'Pending', data:dataPending,  borderColor:'#f59e0b',backgroundColor:'rgba(245,158,11,.07)',fill:true,tension:.4,borderWidth:2,pointRadius:3,pointHoverRadius:5}
            ]
        },
        options:{
            responsive:true,maintainAspectRatio:false,
            plugins:{legend:{display:true,position:'top',labels:{boxWidth:10,padding:16,font:{size:12}}}},
            scales:{x:{grid:{display:false},ticks:{font:{size:11},color:'#94a3b8',autoSkip:true,maxTicksLimit:7}},
                    y:{grid:{color:'rgba(0,0,0,.04)'},ticks:{font:{size:11},color:'#94a3b8'},beginAtZero:true}}
        }
    });

    var labelsDonut=['No Data'],valuesDonut=[100];
    var colors=['#4c1d95','#8b5cf6','#ec4899','#f59e0b','#3b82f6','#10b981'];
    if(typesRaw&&typesRaw.length>0){
        labelsDonut=typesRaw.map(function(i){return i.type||'General';});
        valuesDonut=typesRaw.map(function(i){return parseInt(i.count)||0;});
    }
    var totalSum=valuesDonut.reduce(function(a,b){return a+b;},0);

    new Chart(document.getElementById('letterStatusDoughnutChart').getContext('2d'),{
        type:'doughnut',
        data:{labels:labelsDonut,datasets:[{data:valuesDonut,backgroundColor:colors.slice(0,labelsDonut.length),borderWidth:2,borderColor:'#fff',hoverOffset:6}]},
        options:{responsive:true,maintainAspectRatio:false,cutout:'68%',plugins:{legend:{display:false}}}
    });

    var leg=document.getElementById('js-type-legends');
    leg.innerHTML=labelsDonut.map(function(label,i){
        var pct=totalSum>0?Math.round(valuesDonut[i]/totalSum*100):0;
        return '<div style="display:flex;align-items:center;gap:7px;margin-bottom:8px;font-size:12px">'+
            '<span style="width:9px;height:9px;border-radius:50%;background:'+colors[i]+';flex-shrink:0"></span>'+
            '<span style="color:#475569;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">'+label+'</span>'+
            '<span style="font-weight:700;color:#1e293b">'+pct+'%</span></div>';
    }).join('');
});
</script>