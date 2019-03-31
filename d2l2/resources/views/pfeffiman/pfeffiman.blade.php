@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="pm/css/pacman.css" />
    <link rel="stylesheet" type="text/css" href="pm/css/pacman-home.css" />

   <script type="text/javascript" src="pm/js/jquery.js"></script>
    <script type="text/javascript" src="pm/js/jquery-buzz.js"></script>

    <script type="text/javascript" src="pm/js/game.js"></script>
    <script type="text/javascript" src="pm/js/tools.js"></script>
    <script type="text/javascript" src="pm/js/board.js"></script>
    <script type="text/javascript" src="pm/js/paths.js"></script>
    <script type="text/javascript" src="pm/js/bubbles.js"></script>
    <script type="text/javascript" src="pm/js/fruits.js"></script>
    <script type="text/javascript" src="pm/js/pacman.js"></script>
    <script type="text/javascript" src="pm/js/ghosts.js"></script>
    <script type="text/javascript" src="pm/js/home.js"></script>
    <script type="text/javascript" src="pm/js/sound.js"></script>

    <script type="text/javascript">

        function simulateKeyup(code) {
            var e = jQuery.Event("keyup");
            e.keyCode = code;
            jQuery('body').trigger(e);
        }
        function simulateKeydown(code) {
            var e = jQuery.Event("keydown");
            e.keyCode = code;
            jQuery('body').trigger(e);
        }

        $(document).ready(function() {
            //$.mobile.loading().hide();
            loadAllSound();

            HELP_TIMER = setInterval('blinkHelp()', HELP_DELAY);

            initHome();

            $(".sound").click(function(e) {
                e.stopPropagation();

                var sound = $(this).attr("data-sound");
                if ( sound === "on" ) {
                    $(".sound").attr("data-sound", "off");
                    $(".sound").find("img").attr("src", "pm/img/sound-off.png");
                    GROUP_SOUND.mute();
                } else {
                    $(".sound").attr("data-sound", "on");
                    $(".sound").find("img").attr("src", "pm/img/sound-on.png");
                    GROUP_SOUND.unmute();
                }
            });

            $(".help-button, #help").click(function(e) {
                e.stopPropagation();
                if (!PACMAN_DEAD && !LOCK && !GAMEOVER) {
                    if ( $('#help').css("display") === "none") {
                        $('#help').fadeIn("slow");
                        $(".help-button").hide();
                        if ( $("#panel").css("display") !== "none") {
                            pauseGame();
                        }
                    } else {
                        $('#help').fadeOut("slow");
                        $(".help-button").show();
                    }
                }
            });

            $(".github,.putchu").click(function(e) {
                e.stopPropagation();
            });

            $("#home").on("click touchstart", function(e) {
                if ( $('#help').css("display") === "none") {
                    e.preventDefault();
                    simulateKeydown(13);
                }
            });
            $("#control-up, #control-up-second, #control-up-big").on("mousedown touchstart", function(e) {
                e.preventDefault();
                simulateKeydown(38);
                simulateKeyup(13);
            });
            $("#control-down, #control-down-second, #control-down-big").on("mousedown touchstart", function(e) {
                e.preventDefault();
                simulateKeydown(40);
                simulateKeyup(13);
            });
            $("#control-left, #control-left-big").on("mousedown touchstart", function(e) {
                e.preventDefault();
                simulateKeydown(37);
                simulateKeyup(13);
            });
            $("#control-right, #control-right-big").on("mousedown touchstart", function(e) {
                e.preventDefault();
                simulateKeydown(39);
                simulateKeyup(13);
            });


            $("body").keyup(function(e) {
                KEYDOWN = false;
            });

            $("body").keydown(function(e) {

                if (HOME) {

                    initGame(true);

                } else {
                    //if (!KEYDOWN) {
                    KEYDOWN = true;
                    if (PACMAN_DEAD && !LOCK) {
                        erasePacman();
                        resetPacman();
                        drawPacman();

                        eraseGhosts();
                        resetGhosts();
                        drawGhosts();
                        moveGhosts();

                        blinkSuperBubbles();

                    } else if (e.keyCode >= 37 && e.keyCode <= 40 && !PAUSE && !PACMAN_DEAD && !LOCK) {
                        if ( e.keyCode === 39 ) {
                            movePacman(1);
                        } else if ( e.keyCode === 40 ) {
                            movePacman(2);
                        } else if ( e.keyCode === 37 ) {
                            movePacman(3);
                        } else if ( e.keyCode === 38 ) {
                            movePacman(4);
                        }
                    } else if (e.keyCode === 68 && !PAUSE) {
                        /*if ( $("#canvas-paths").css("display") === "none" ) {
                            $("#canvas-paths").show();
                        } else {
                            $("#canvas-paths").hide();
                        }*/
                    } else if (e.keyCode === 80 && !PACMAN_DEAD && !LOCK) {
                        if (PAUSE) {
                            resumeGame();
                        } else {
                            pauseGame();
                        }
                    } else if (GAMEOVER) {
                        initHome();
                    }
                    //}
                }
            });
        });
    </script>

    <title>D2L2 Pfeffiman</title>
    </head>

    <body>

    <div id="sound"></div>

    <div id="help">
        <h2>Help</h2>
        <table align="center" border="0" cellPadding="2" cellSpacing="0">
            <tbody>
            <tr><td>Arrow Left : </td><td>Move Left</td></tr>
            <tr><td>Arrow Right : </td><td>Move Right</td></tr>
            <tr><td>Arrow Down : </td><td>Move Down</td></tr>
            <tr><td>Arrow Up : </td><td>Move Up</td></tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr><td>P : </td><td>PAUSE</td></tr>
            </tbody>
        </table>
    </div>

    <div id="home">
        <h1>PFEFFIMAN</h1>
        <h3>PFEFFIMAN<br></h3>
        <div id="presentation">
            <div id="presentation-titles">character &nbsp;/&nbsp; nickname</div>
            <canvas id="canvas-presentation-blinky"></canvas><div id="presentation-character-blinky">- shadow</div><div id="presentation-name-blinky">"blinky"</div>
            <canvas id="canvas-presentation-pinky"></canvas><div id="presentation-character-pinky">- speedy</div><div id="presentation-name-pinky">"pinky"</div>
            <canvas id="canvas-presentation-inky"></canvas><div id="presentation-character-inky">- bashful</div><div id="presentation-name-inky">"inky"</div>
            <canvas id="canvas-presentation-clyde"></canvas><div id="presentation-character-clyde">- pokey</div><div id="presentation-name-clyde">"clyde"</div>
        </div>
        <canvas id="trailer"></canvas>
        <div class="help-button">- help -</div>
        <a class="sound" href="javascript:void(0);" data-sound="on"><img src="pm/img/sound-on.png" alt="" border="0"></a>
        </div>

    <div id="panel">
        <h1>PEFFIMAN</h1>
        <canvas id="canvas-panel-title-pacman"></canvas>
        <div id="score"><h2>1UP</h2><span>00</span></div>
        <div id="highscore"><h2>High Score</h2><span>00</span></div>
        <div id="board">
            <canvas id="canvas-board"></canvas>
            <canvas id="canvas-paths"></canvas>
            <canvas id="canvas-bubbles"></canvas>
            <canvas id="canvas-fruits"></canvas>
            <canvas id="canvas-pacman"></canvas>
            <canvas id="canvas-ghost-blinky"></canvas>
            <canvas id="canvas-ghost-pinky"></canvas>
            <canvas id="canvas-ghost-inky"></canvas>
            <canvas id="canvas-ghost-clyde"></canvas>
            <div id="control-up-big"></div>
            <div id="control-down-big"></div>
            <div id="control-left-big"></div>
            <div id="control-right-big"></div>
        </div>
        <div id="control">
            <div id="control-up"></div>
            <div id="control-up-second"></div>
            <div id="control-down"></div>
            <div id="control-down-second"></div>
            <div id="control-left"></div>
            <div id="control-right"></div>
        </div>
        <canvas id="canvas-lifes"></canvas>
        <canvas id="canvas-level-fruits"></canvas>
        <div id="message"></div>
        <div class="help-button">- help -</div>
        <a class="sound" href="javascript:void(0);" data-sound="on"><img src="pm/img/sound-on.png" alt="" border="0"></a>
    </div>



    <div style="display:none;">
        <img id="source"
             src="/pm/img/pfeffi.jpg"
             width="300" height="227">
    </div>
    J


@endsection

@section('script')

    <script>

    var EATING_SOUND = new buzz.sound([
    "./pm/sound/eating.mp3"
    ]);
    var GHOST_EATEN_SOUND = new buzz.sound([
    "./pm/sound/ghost-eaten.mp3"
    ]);
    var EXTRA_LIFE_SOUND = new buzz.sound([
    "./pm/sound/extra-life.mp3"
    ]);
    var EAT_PILL_SOUND = new buzz.sound([
    "./pm/sound/eat-pill.mp3"
    ]);
    var EAT_FRUIT_SOUND = new buzz.sound([
    "./pm/sound/eat-fruit.mp3"
    ]);
    var EAT_GHOST_SOUND = new buzz.sound([
    "./pm/sound/eat-ghost.mp3"
    ]);
    var SIREN_SOUND = new buzz.sound([
    "./pm/sound/siren.mp3"
    ]);
    var WAZA_SOUND = new buzz.sound([
    "./pm/sound/waza.mp3"
    ]);
    var READY_SOUND = new buzz.sound([
    "./pm/sound/ready.mp3"
    ]);
    var DIE_SOUND = new buzz.sound([
    "./pm/sound/die.mp3"
    ]);

    var GROUP_SOUND = new buzz.group([EATING_SOUND, SIREN_SOUND, EAT_PILL_SOUND, EAT_GHOST_SOUND, READY_SOUND, DIE_SOUND, WAZA_SOUND, GHOST_EATEN_SOUND, EXTRA_LIFE_SOUND, EAT_FRUIT_SOUND]);

    var EATING_SOUND_LOOPING = false;

    function isAvailableSound() {
    return !($("#sound").css("display") === "none");
    }

    function loadAllSound() {
    if (isAvailableSound()) GROUP_SOUND.load();
    }

    function playEatingSound() {
    if (isAvailableSound()) {
    if (!EATING_SOUND_LOOPING) {
    EATING_SOUND_LOOPING = true;

    EATING_SOUND.setSpeed(1.35);
    EATING_SOUND.loop();
    EATING_SOUND.play();
    }
    }
    }

    function stopEatingSound() {
    if (isAvailableSound()) {
    if (EATING_SOUND_LOOPING) {
    EATING_SOUND.unloop();
    EATING_SOUND_LOOPING = false;
    }
    }
    }

    function playExtraLifeSound() {
    if (isAvailableSound()) {
    EXTRA_LIFE_SOUND.play();
    }
    }

    function playEatFruitSound() {
    if (isAvailableSound()) {
    EAT_FRUIT_SOUND.play();
    }
    }

    function playEatPillSound() {
    if (isAvailableSound()) {
    EAT_PILL_SOUND.play();
    }
    }

    function playEatGhostSound() {
    if (isAvailableSound()) {
    EAT_GHOST_SOUND.play();
    }
    }

    function playWazaSound() {
    if (isAvailableSound()) {
    stopSirenSound();
    stopEatSound();
    WAZA_SOUND.loop();
    WAZA_SOUND.play();
    }
    }

    function stopWazaSound() {
    if (isAvailableSound()) {
    WAZA_SOUND.stop();
    }
    }

    function playGhostEatenSound() {
    if (isAvailableSound()) {
    stopSirenSound();
    stopWazaSound();
    GHOST_EATEN_SOUND.play();
    GHOST_EATEN_SOUND.loop();
    }
    }

    function stopEatSound() {
    if (isAvailableSound()) {
    GHOST_EATEN_SOUND.stop();
    }
    }


    function playReadySound() {
    if (isAvailableSound()) {
    READY_SOUND.play();
    }
    }

    function playDieSound() {
    if (isAvailableSound()) {
    GROUP_SOUND.stop();
    DIE_SOUND.play();
    }
    }

    function playSirenSound() {
    if (isAvailableSound()) {
    stopWazaSound();
    stopEatSound();
    SIREN_SOUND.loop();
    SIREN_SOUND.play();
    }
    }

    function stopSirenSound() {
    if (isAvailableSound()) {
    SIREN_SOUND.stop();
    }
    }

    function stopAllSound() {
    if (isAvailableSound()) {
    GROUP_SOUND.stop();
    }
    }


    var HOME = false;

    var HOME_PRESENTATION_TIMER = -1;
    var HOME_PRESENTATION_STATE = 0;

    var HOME_TRAILER_TIMER = -1;
    var HOME_TRAILER_STATE = 0;

    var PACMAN_TRAILER_CANVAS_CONTEXT = null;
    var PACMAN_TRAILER_DIRECTION = 3;
    var PACMAN_TRAILER_POSITION_X = 600;
    var PACMAN_TRAILER_POSITION_Y = 25;
    var PACMAN_TRAILER_POSITION_STEP = 3;
    var PACMAN_TRAILER_MOUNTH_STATE = 3;
    var PACMAN_TRAILER_MOUNTH_STATE_MAX = 6;
    var PACMAN_TRAILER_SIZE = 16;

    var GHOST_TRAILER_CANVAS_CONTEXT = null;
    var GHOST_TRAILER_BODY_STATE_MAX = 6;
    var GHOST_TRAILER_POSITION_STEP = 3;

    var GHOST_BLINKY_TRAILER_POSITION_X = 1000;
    var GHOST_BLINKY_TRAILER_POSITION_Y = 25;
    var GHOST_BLINKY_TRAILER_DIRECTION = 3;
    var GHOST_BLINKY_TRAILER_COLOR = "#ed1b24";
    var GHOST_BLINKY_TRAILER_BODY_STATE = 0;
    var GHOST_BLINKY_TRAILER_STATE = 0;

    var GHOST_PINKY_TRAILER_POSITION_X = 1035;
    var GHOST_PINKY_TRAILER_POSITION_Y = 25;
    var GHOST_PINKY_TRAILER_DIRECTION = 3;
    var GHOST_PINKY_TRAILER_COLOR = "#feaec9";
    var GHOST_PINKY_TRAILER_BODY_STATE = 1;
    var GHOST_PINKY_TRAILER_STATE = 0;

    var GHOST_INKY_TRAILER_POSITION_X = 1070;
    var GHOST_INKY_TRAILER_POSITION_Y = 25;
    var GHOST_INKY_TRAILER_DIRECTION = 3;
    var GHOST_INKY_TRAILER_COLOR = "#4adecb";
    var GHOST_INKY_TRAILER_BODY_STATE = 2;
    var GHOST_INKY_TRAILER_STATE = 0;

    var GHOST_CLYDE_TRAILER_POSITION_X = 1105;
    var GHOST_CLYDE_TRAILER_POSITION_Y = 25;
    var GHOST_CLYDE_TRAILER_DIRECTION = 3;
    var GHOST_CLYDE_TRAILER_COLOR = "#f99c00";
    var GHOST_CLYDE_TRAILER_BODY_STATE = 3;
    var GHOST_CLYDE_TRAILER_STATE = 0;

    function initHome() {
        HOME = true;

        GAMEOVER = false;
        LOCK = false;
        PACMAN_DEAD = false;


        $("#panel").hide();
        $("#home").show();
        $("#home h3 em").append( " - " + new Date().getFullYear() );

        $('#help').fadeOut("slow");

        var ctx = null;
        /*var canvas = document.getElementById('canvas-home-title-pacman');
        canvas.setAttribute('width', '115');
        canvas.setAttribute('height', '100');
        if (canvas.getContext) {
            ctx = canvas.getContext('2d');
        }

        var x = 50;
        var y = 50;

        ctx.fillStyle = "#fff200";
        ctx.beginPath();
        ctx.arc(x, y, 45, (0.35 - (3 * 0.05)) * Math.PI, (1.65 + (3 * 0.05)) * Math.PI, false);
        ctx.lineTo(x - 10, y);
        ctx.fill();
        ctx.closePath();

        x = 95;
        y = 50;

        ctx.fillStyle = "#dca5be";
        ctx.beginPath();
        ctx.arc(x, y, 10, 0, 2 * Math.PI, false);
        ctx.fill();
        ctx.closePath(); */

        canvas = document.getElementById('canvas-presentation-blinky');
        canvas.setAttribute('width', '50');
        canvas.setAttribute('height', '50');
        if (canvas.getContext) {
            ctx = canvas.getContext('2d');
        }
        ctx.fillStyle = GHOST_BLINKY_COLOR;
        drawHelperGhost(ctx, 25, 25, 1, 0, 0, 0);

        canvas = document.getElementById('canvas-presentation-pinky');
        canvas.setAttribute('width', '50');
        canvas.setAttribute('height', '50');
        if (canvas.getContext) {
            ctx = canvas.getContext('2d');
        }
        ctx.fillStyle = GHOST_PINKY_COLOR;
        drawHelperGhost(ctx, 25, 25, 1, 0, 0, 0);

        canvas = document.getElementById('canvas-presentation-inky');
        canvas.setAttribute('width', '50');
        canvas.setAttribute('height', '50');
        if (canvas.getContext) {
            ctx = canvas.getContext('2d');
        }
        ctx.fillStyle = GHOST_INKY_COLOR;
        drawHelperGhost(ctx, 25, 25, 1, 0, 0, 0);

        canvas = document.getElementById('canvas-presentation-clyde');
        canvas.setAttribute('width', '50');
        canvas.setAttribute('height', '50');
        if (canvas.getContext) {
            ctx = canvas.getContext('2d');
        }
        ctx.fillStyle = GHOST_CLYDE_COLOR;
        drawHelperGhost(ctx, 25, 25, 1, 0, 0, 0);

        startPresentation();
    }

    function startPresentation() {
        $("#presentation *").hide();

        if (HOME_PRESENTATION_TIMER === -1) {
            HOME_PRESENTATION_STATE = 0;
            HOME_PRESENTATION_TIMER = setInterval("nextSequencePresentation()", 500);
        }
    }
    function stopPresentation() {

        if (HOME_PRESENTATION_TIMER != -1) {
            $("#presentation *").hide();
            HOME_PRESENTATION_STATE = 0;
            clearInterval(HOME_PRESENTATION_TIMER);
            HOME_PRESENTATION_TIMER = -1;
        }
    }
    function nextSequencePresentation() {
        if (HOME_PRESENTATION_STATE === 0) {
            $("#presentation-titles").show();
        } else if (HOME_PRESENTATION_STATE === 2) {
            $("#canvas-presentation-blinky").show();
        } else if (HOME_PRESENTATION_STATE === 4) {
            $("#presentation-character-blinky").show();
        } else if (HOME_PRESENTATION_STATE === 5) {
            $("#presentation-name-blinky").show();
        } else if (HOME_PRESENTATION_STATE === 6) {
            $("#canvas-presentation-pinky").show();
        } else if (HOME_PRESENTATION_STATE === 8) {
            $("#presentation-character-pinky").show();
        } else if (HOME_PRESENTATION_STATE === 9) {
            $("#presentation-name-pinky").show();
        } else if (HOME_PRESENTATION_STATE === 10) {
            $("#canvas-presentation-inky").show();
        } else if (HOME_PRESENTATION_STATE === 12) {
            $("#presentation-character-inky").show();
        } else if (HOME_PRESENTATION_STATE === 13) {
            $("#presentation-name-inky").show();
        } else if (HOME_PRESENTATION_STATE === 14) {
            $("#canvas-presentation-clyde").show();
        } else if (HOME_PRESENTATION_STATE === 16) {
            $("#presentation-character-clyde").show();
        } else if (HOME_PRESENTATION_STATE === 17) {
            $("#presentation-name-clyde").show();
        }

        if (HOME_PRESENTATION_STATE === 17) {
            clearInterval(HOME_PRESENTATION_TIMER);
            HOME_PRESENTATION_TIMER = -1;

            startTrailer();
        } else {
            HOME_PRESENTATION_STATE ++;
        }
    }

    function startTrailer() {

        var canvas = document.getElementById('trailer');
        canvas.setAttribute('width', '500');
        canvas.setAttribute('height', '50');
        if (canvas.getContext) {
            PACMAN_TRAILER_CANVAS_CONTEXT = canvas.getContext('2d');
        }

        if (HOME_TRAILER_TIMER === -1) {
            HOME_TRAILER_STATE = 0;
            HOME_TRAILER_TIMER = setInterval("nextSequenceTrailer()", 20);
        }
    }
    function stopTrailer() {

        if (HOME_TRAILER_TIMER != -1) {
            $("#presentation *").hide();
            HOME_TRAILER_STATE = 0;
            clearInterval(HOME_TRAILER_TIMER);
            HOME_TRAILER_TIMER = -1;
        }
    }
    function nextSequenceTrailer() {

        erasePacmanTrailer();
        eraseGhostsTrailer();

        if (PACMAN_TRAILER_MOUNTH_STATE < PACMAN_TRAILER_MOUNTH_STATE_MAX) {
            PACMAN_TRAILER_MOUNTH_STATE ++;
        } else {
            PACMAN_TRAILER_MOUNTH_STATE = 0;
        }
        if ( PACMAN_TRAILER_DIRECTION === 1 ) {
            PACMAN_TRAILER_POSITION_X += PACMAN_TRAILER_POSITION_STEP;
        } else if ( PACMAN_TRAILER_DIRECTION === 3 ) {
            PACMAN_TRAILER_POSITION_X -= PACMAN_TRAILER_POSITION_STEP;
        }
        if ( PACMAN_TRAILER_POSITION_X < -650) {
            PACMAN_TRAILER_DIRECTION = 1;
            PACMAN_TRAILER_POSITION_STEP ++;
        }

        if (GHOST_BLINKY_TRAILER_BODY_STATE < GHOST_TRAILER_BODY_STATE_MAX) {
            GHOST_BLINKY_TRAILER_BODY_STATE ++;
        } else {
            GHOST_BLINKY_TRAILER_BODY_STATE = 0;
        }
        if (GHOST_PINKY_TRAILER_BODY_STATE < GHOST_TRAILER_BODY_STATE_MAX) {
            GHOST_PINKY_TRAILER_BODY_STATE ++;
        } else {
            GHOST_PINKY_TRAILER_BODY_STATE = 0;
        }
        if (GHOST_INKY_TRAILER_BODY_STATE < GHOST_TRAILER_BODY_STATE_MAX) {
            GHOST_INKY_TRAILER_BODY_STATE ++;
        } else {
            GHOST_INKY_TRAILER_BODY_STATE = 0;
        }
        if (GHOST_CLYDE_TRAILER_BODY_STATE < GHOST_TRAILER_BODY_STATE_MAX) {
            GHOST_CLYDE_TRAILER_BODY_STATE ++;
        } else {
            GHOST_CLYDE_TRAILER_BODY_STATE = 0;
        }
        if ( GHOST_BLINKY_TRAILER_DIRECTION === 1 ) {
            GHOST_BLINKY_TRAILER_POSITION_X += GHOST_TRAILER_POSITION_STEP;
        } else if ( GHOST_BLINKY_TRAILER_DIRECTION === 3 ) {
            GHOST_BLINKY_TRAILER_POSITION_X -= GHOST_TRAILER_POSITION_STEP;
        }
        if ( GHOST_PINKY_TRAILER_DIRECTION === 1 ) {
            GHOST_PINKY_TRAILER_POSITION_X += GHOST_TRAILER_POSITION_STEP;
        } else if ( GHOST_PINKY_TRAILER_DIRECTION === 3 ) {
            GHOST_PINKY_TRAILER_POSITION_X -= GHOST_TRAILER_POSITION_STEP;
        }
        if ( GHOST_INKY_TRAILER_DIRECTION === 1 ) {
            GHOST_INKY_TRAILER_POSITION_X += GHOST_TRAILER_POSITION_STEP;
        } else if ( GHOST_INKY_TRAILER_DIRECTION === 3 ) {
            GHOST_INKY_TRAILER_POSITION_X -= GHOST_TRAILER_POSITION_STEP;
        }
        if ( GHOST_CLYDE_TRAILER_DIRECTION === 1 ) {
            GHOST_CLYDE_TRAILER_POSITION_X += GHOST_TRAILER_POSITION_STEP;
        } else if ( GHOST_CLYDE_TRAILER_DIRECTION === 3 ) {
            GHOST_CLYDE_TRAILER_POSITION_X -= GHOST_TRAILER_POSITION_STEP;
        }
        if ( GHOST_BLINKY_TRAILER_POSITION_X < -255) {
            GHOST_BLINKY_TRAILER_DIRECTION = 1;
            GHOST_BLINKY_TRAILER_STATE = 1;
        }
        if ( GHOST_PINKY_TRAILER_POSITION_X < -220) {
            GHOST_PINKY_TRAILER_DIRECTION = 1;
            GHOST_PINKY_TRAILER_STATE = 1;
        }
        if ( GHOST_INKY_TRAILER_POSITION_X < -185) {
            GHOST_INKY_TRAILER_DIRECTION = 1;
            GHOST_INKY_TRAILER_STATE = 1;
        }
        if ( GHOST_CLYDE_TRAILER_POSITION_X < -150) {
            GHOST_CLYDE_TRAILER_DIRECTION = 1;
            GHOST_CLYDE_TRAILER_STATE = 1;
        }

        drawPacmanTrailer();
        drawGhostsTrailer();

        if (HOME_TRAILER_STATE === 750) {
            clearInterval(HOME_TRAILER_TIMER);
            HOME_TRAILER_TIMER = -1;
        } else {
            HOME_TRAILER_STATE ++;
        }
    }

    function getGhostsTrailerCanevasContext() {
        return PACMAN_TRAILER_CANVAS_CONTEXT;
    }
    function drawGhostsTrailer() {
        var ctx = getGhostsTrailerCanevasContext();

        if (GHOST_BLINKY_TRAILER_STATE === 1) {
            ctx.fillStyle = GHOST_AFFRAID_COLOR;
        } else {
            ctx.fillStyle = GHOST_BLINKY_COLOR;
        }
        drawHelperGhost(ctx, GHOST_BLINKY_TRAILER_POSITION_X, GHOST_BLINKY_TRAILER_POSITION_Y, GHOST_BLINKY_TRAILER_DIRECTION, GHOST_BLINKY_TRAILER_BODY_STATE, GHOST_BLINKY_TRAILER_STATE, 0);

        if (GHOST_PINKY_TRAILER_STATE === 1) {
            ctx.fillStyle = GHOST_AFFRAID_COLOR;
        } else {
            ctx.fillStyle = GHOST_PINKY_COLOR;
        }
        drawHelperGhost(ctx, GHOST_PINKY_TRAILER_POSITION_X, GHOST_PINKY_TRAILER_POSITION_Y, GHOST_PINKY_TRAILER_DIRECTION, GHOST_PINKY_TRAILER_BODY_STATE, GHOST_PINKY_TRAILER_STATE, 0);

        if (GHOST_INKY_TRAILER_STATE === 1) {
            ctx.fillStyle = GHOST_AFFRAID_COLOR;
        } else {
            ctx.fillStyle = GHOST_INKY_COLOR;
        }
        drawHelperGhost(ctx, GHOST_INKY_TRAILER_POSITION_X, GHOST_INKY_TRAILER_POSITION_Y, GHOST_INKY_TRAILER_DIRECTION, GHOST_INKY_TRAILER_BODY_STATE, GHOST_INKY_TRAILER_STATE, 0);

        if (GHOST_CLYDE_TRAILER_STATE === 1) {
            ctx.fillStyle = GHOST_AFFRAID_COLOR;
        } else {
            ctx.fillStyle = GHOST_CLYDE_COLOR;
        }
        drawHelperGhost(ctx, GHOST_CLYDE_TRAILER_POSITION_X, GHOST_CLYDE_TRAILER_POSITION_Y, GHOST_CLYDE_TRAILER_DIRECTION, GHOST_CLYDE_TRAILER_BODY_STATE, GHOST_CLYDE_TRAILER_STATE, 0);
    }
    function eraseGhostsTrailer(ghost) {

        var ctx = getGhostsTrailerCanevasContext();

        ctx.clearRect(GHOST_BLINKY_TRAILER_POSITION_X - 17, GHOST_BLINKY_TRAILER_POSITION_Y - 17, 34, 34);
        ctx.clearRect(GHOST_PINKY_TRAILER_POSITION_X - 17, GHOST_BLINKY_TRAILER_POSITION_Y - 17, 34, 34);
        ctx.clearRect(GHOST_INKY_TRAILER_POSITION_X - 17, GHOST_BLINKY_TRAILER_POSITION_Y - 17, 34, 34);
        ctx.clearRect(GHOST_CLYDE_TRAILER_POSITION_X - 17, GHOST_BLINKY_TRAILER_POSITION_Y - 17, 34, 34);
    }

    function getPacmanTrailerCanevasContext() {
        return PACMAN_TRAILER_CANVAS_CONTEXT;
    }
    function drawPacmanTrailer() {

        var ctx = getPacmanTrailerCanevasContext();

        ctx.fillStyle = "#fff200";
        ctx.beginPath();

        var startAngle = 0;
        var endAngle = 2 * Math.PI;
        var lineToX = PACMAN_TRAILER_POSITION_X;
        var lineToY = PACMAN_TRAILER_POSITION_Y;
        if (PACMAN_TRAILER_DIRECTION === 1) {
            startAngle = (0.35 - (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            endAngle = (1.65 + (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            lineToX -= 8;
        } else if (PACMAN_TRAILER_DIRECTION === 2) {
            startAngle = (0.85 - (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            endAngle = (0.15 + (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            lineToY -= 8;
        } else if (PACMAN_TRAILER_DIRECTION === 3) {
            startAngle = (1.35 - (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            endAngle = (0.65 + (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            lineToX += 8;
        } else if (PACMAN_TRAILER_DIRECTION === 4) {
            startAngle = (1.85 - (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            endAngle = (1.15 + (PACMAN_TRAILER_MOUNTH_STATE * 0.05)) * Math.PI;
            lineToY += 8;
        }
        ctx.arc(PACMAN_TRAILER_POSITION_X, PACMAN_TRAILER_POSITION_Y, PACMAN_TRAILER_SIZE, startAngle, endAngle, false);
        ctx.lineTo(lineToX, lineToY);
        ctx.fill();
        ctx.closePath();
    }
    function erasePacmanTrailer() {

        var ctx = getPacmanTrailerCanevasContext();
        ctx.clearRect(PACMAN_TRAILER_POSITION_X - PACMAN_TRAILER_SIZE, PACMAN_TRAILER_POSITION_Y - PACMAN_TRAILER_SIZE, PACMAN_TRAILER_SIZE * 2, PACMAN_TRAILER_SIZE * 2);
    }


    var FRUITS_CANVAS_CONTEXT = null;
    var LEVEL_FRUITS_CANVAS_CONTEXT = null;
    var FRUITS_SIZE = 30;

    var FRUITS_POSITION_X = 276;
    var FRUITS_POSITION_Y = 310;

    var FRUIT_MINIMUM_START = 15;
    var FRUIT_CANCEL_TIMER = null;
    var FRUIT_CANCEL_SPEED = 7500;
    var FRUIT = null;


    function initFruits() {
        var canvas = document.getElementById('canvas-fruits');
        canvas.setAttribute('width', '550');
        canvas.setAttribute('height', '550');
        if (canvas.getContext) {
            FRUITS_CANVAS_CONTEXT = canvas.getContext('2d');
        }

        var levelCanvas = document.getElementById('canvas-level-fruits');
        levelCanvas.setAttribute('width', '265');
        levelCanvas.setAttribute('height', '30');
        if (levelCanvas.getContext) {
            LEVEL_FRUITS_CANVAS_CONTEXT = levelCanvas.getContext('2d');
        }

        var ctx = getLevelFruitsCanevasContext();
        ctx.clearRect(0, 0, 265, 30);

        var x = 245;
        var y = 14;
        var i = 0;

        if (LEVEL > 7) {
            var l = LEVEL
            if (l > 13) l = 13;
            i = -(l - 7);
        }

        drawFruit(ctx, "cherry", x - ( i * 37), y, 27);
        i ++;

        if (LEVEL > 1) {
            drawFruit(ctx, "strawberry", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 2) {
            drawFruit(ctx, "orange", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 3) {
            drawFruit(ctx, "orange", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 4) {
            drawFruit(ctx, "apple", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 5) {
            drawFruit(ctx, "apple", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 6) {
            drawFruit(ctx, "melon", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 7) {
            drawFruit(ctx, "melon", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 8) {
            drawFruit(ctx, "galboss", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 9) {
            drawFruit(ctx, "galboss", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 10) {
            drawFruit(ctx, "bell", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 11) {
            drawFruit(ctx, "bell", x - ( i * 37), y, 27);
            i ++;
        }
        if (LEVEL > 12) {
            drawFruit(ctx, "key", x - ( i * 37), y, 27);
            i ++;
        }
    }

    function getFruitsCanevasContext() {
        return FRUITS_CANVAS_CONTEXT;
    }
    function getLevelFruitsCanevasContext() {
        return LEVEL_FRUITS_CANVAS_CONTEXT;
    }

    function eatFruit() {
        playEatFruitSound();

        var s = 0;
        if (FRUIT === "cherry")  s = 100;
        else if (FRUIT === "strawberry")  s = 300;
        else if (FRUIT === "orange")  s = 500;
        else if (FRUIT === "apple")  s = 700;
        else if (FRUIT === "melon")  s = 1000;
        else if (FRUIT === "galboss")  s = 2000;
        else if (FRUIT === "bell")  s = 3000;
        else if (FRUIT === "key")  s = 5000;

        score(s, "fruit");
        cancelFruit();
    }

    function fruit() {

        if (TIME_FRUITS === 2 && $("#board .fruits").length > 0) {
            $("#board .fruits").remove();
        }
        if (TIME_FRUITS > FRUIT_MINIMUM_START) {
            if (anyGoodIdea() > 3) {
                oneFruit();
            }
        }
    }
    function oneFruit() {
        if ( FRUIT_CANCEL_TIMER === null ) {
            var ctx = getFruitsCanevasContext();

            if (LEVEL === 1) FRUIT = "cherry";
            else if (LEVEL === 2) FRUIT = "strawberry";
            else if (LEVEL === 3 || LEVEL === 4) FRUIT = "orange";
            else if (LEVEL === 5 || LEVEL === 6) FRUIT = "apple";
            else if (LEVEL === 7 || LEVEL === 8) FRUIT = "melon";
            else if (LEVEL === 9 || LEVEL === 10) FRUIT = "galboss";
            else if (LEVEL === 11 || LEVEL === 12) FRUIT = "bell";
            else if (LEVEL === 13) FRUIT = "key";

            drawFruit(ctx, FRUIT, FRUITS_POSITION_X, FRUITS_POSITION_Y, FRUITS_SIZE);
            FRUIT_CANCEL_TIMER = new Timer("cancelFruit()", FRUIT_CANCEL_SPEED);
        }
    }
    function cancelFruit() {
        eraseFruit();
        FRUIT_CANCEL_TIMER.cancel();
        FRUIT_CANCEL_TIMER = null;
        TIME_FRUITS = 0;
    }

    function eraseFruit() {

        var ctx = getFruitsCanevasContext();
        //ctx.translate(FRUITS_POSITION_X - (FRUITS_SIZE / 2), FRUITS_POSITION_Y - (FRUITS_SIZE / 2));
        //ctx.save();
        //ctx.globalCompositeOperation = "destination-out";

        //ctx.beginPath();
        //ctx.translate(FRUITS_POSITION_X - (FRUITS_SIZE / 2), FRUITS_POSITION_Y - (FRUITS_SIZE / 2));
        ctx.clearRect(FRUITS_POSITION_X - (FRUITS_SIZE), FRUITS_POSITION_Y - (FRUITS_SIZE), FRUITS_SIZE * 2, FRUITS_SIZE * 2);
        //ctx.fill();
        //ctx.closePath();

        //ctx.restore();
    }

    function drawFruit(ctx, f, x, y, size) {
        ctx.save();
        image = document.getElementById('source');
        ctx.drawImage(image, 0,0);
        /*
            if ( f === "cherry" ) drawCherry(ctx, x, y, size);
            else if ( f === "strawberry" ) drawStrawberry(ctx, x, y, size);
            else if ( f === "orange" ) drawOrange(ctx, x, y, size);
            else if ( f === "apple" ) drawApple(ctx, x, y, size);
            else if ( f === "melon" ) drawMelon(ctx, x, y + 7, size / 1.6);
            else if ( f === "galboss" ) drawGalboss(ctx, x, y, size);
            else if ( f === "bell" ) drawBell(ctx, x, y, size);
            else if ( f === "key" ) drawKey(ctx, x, y, size);
        */

        ctx.restore();
    }

    function drawKey(ctx, x, y, size) {
        ctx.translate(x - (size / 2), y - (size / 2));

        ctx.fillStyle = "#52c4cc";
        ctx.beginPath();
        ctx.rect(size / 3, 5, (size - (size / 3)), size / 3);
        ctx.rect((size / 6) * 3, 2, (size - ((size / 3) * 2)), size / (size / 3));
        ctx.fill();

        ctx.fillStyle = "#000";
        ctx.beginPath();
        ctx.rect((size / 6) * 3, (size / 6), (size - ((size / 3) * 2)), size / 10);
        ctx.fill();

        ctx.strokeStyle = "#ccc";
        ctx.lineWidth = "3";

        ctx.beginPath();
        ctx.moveTo((size / 2) + 2, size - 4);
        ctx.lineTo((size / 2) + 2, size / 2);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo((size / 2) + 7, size - 4);
        ctx.lineTo((size / 2) + 7, size / 2);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo((size / 2) + 4, size - 4);
        ctx.lineTo((size / 2) + 4, size - 1);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo((size / 2) + 5, size - 4);
        ctx.lineTo((size / 2) + 5, size - 1);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo((size / 2) + 9, (size / 2) + 2);
        ctx.lineTo((size / 2) + 9, (size / 2) + 5);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo((size / 2) + 10, (size / 2) + 8);
        ctx.lineTo((size / 2) + 10, (size / 2) + 11);
        ctx.stroke();


        ctx.closePath();
    }

    function drawBell(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2));

        ctx.oval(size / 2, size / 2, size / 1, size - 5);
        ctx.fillStyle = "#fff200";
        ctx.fill();

        ctx.beginPath();
        ctx.rect(4, size - (size / 2.5) - 3, size - 8, (size / 2.5) - 1);
        ctx.fill();

        ctx.fillStyle = "#52c4cc";
        ctx.beginPath();
        ctx.rect(4 + 2, size - 6, (size - 12), 5);
        ctx.fill();

        ctx.fillStyle = "#8c8c8c";
        ctx.beginPath();
        ctx.rect(size / 2, size - 6, 5, 5);
        ctx.fill();

        ctx.closePath();

        ctx.strokeStyle = "#bbb";
        ctx.lineWidth = "2";
        ctx.beginPath();
        ctx.moveTo(15, 7);
        ctx.arcTo(8, 7, 8, 30, 9);
        ctx.stroke();

        ctx.closePath();
    }
    function drawGalboss(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2) + 1);

        ctx.strokeStyle = "#868df5";
        ctx.lineWidth = "5";

        ctx.beginPath();
        ctx.moveTo((size / 2), (size / 2) + (size / 4));
        ctx.arcTo(size - 1, (size / 2) + 4, size - 1, (size / 2) + 1, (size / 3));
        ctx.lineTo(size - 1, 4);
        ctx.stroke();
        ctx.closePath();

        ctx.beginPath();
        ctx.moveTo((size / 2), (size / 2) + (size / 4));
        ctx.arcTo(1, (size / 2) + 4, 1, (size / 2) + 1, (size / 3));
        ctx.lineTo(1, 4);
        ctx.stroke();
        ctx.closePath();

        ctx.strokeStyle = "#ffff00";
        ctx.lineWidth = "6";

        ctx.beginPath();
        ctx.moveTo(size / 2, (size / 2) - 2);
        ctx.lineTo(size / 2, size);
        ctx.stroke();

        ctx.fillStyle = "#ffff00";

        ctx.beginPath();
        ctx.arc((size / 2), size / 3.5, size / 2.5, 0, Math.PI * 1);
        ctx.fill();
        ctx.closePath();

        ctx.strokeStyle = "#000";
        ctx.lineWidth = "3";

        ctx.beginPath();
        ctx.moveTo(size / 2 - (size / 6), (size / 2) + 1);
        ctx.lineTo(size / 2 - (size / 6), size);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(size / 2 + (size / 6), (size / 2) + 1);
        ctx.lineTo(size / 2 + (size / 6), size);
        ctx.stroke();

        ctx.strokeStyle = "#ff3f3f";
        ctx.lineWidth = "4";

        ctx.beginPath();
        ctx.moveTo(size / 2, (size / 2));
        ctx.lineTo((size / 2), 2);
        ctx.stroke();

        ctx.moveTo((size / 2) + 1, 2);
        ctx.lineTo((size / 2) - 8, (size / 2) - (size / 6));
        ctx.stroke();

        ctx.moveTo((size / 2) - 1, 2);
        ctx.lineTo((size / 2) + 8, (size / 2) - (size / 6));
        ctx.stroke();

        ctx.closePath();

    }
    function drawMelon(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2));

        ctx.fillStyle = "#198122";
        ctx.beginPath();
        ctx.moveTo(size / 2, size / 6);
        ctx.arc(size / 2, size / 6, size / 1.15, 1.1, 2.5, true);
        ctx.fill();
        ctx.closePath();

        ctx.beginPath();
        ctx.fillStyle = "#ACFB77";
        ctx.moveTo(size / 2, size / 6);
        ctx.arc(size / 2, size / 6, size / 1.3, 1.1, 2.5, true);
        ctx.fill();
        ctx.closePath();

        ctx.beginPath();
        ctx.fillStyle = "#F92F2F";
        ctx.moveTo(size / 2, size / 6);
        ctx.arc(size / 2, size / 6, size / 1.7, 1.1, 2.5, true);
        ctx.fill();
        ctx.closePath();

        var mod = size / 23;
        ctx.beginPath();
        ctx.fillStyle = "black";
        ctx.moveTo(12 * mod, 9 * mod);
        ctx.arc(12 * mod, 9 * mod, size / 12, 1.1, 2.5, true);
        ctx.moveTo(13 * mod, 12 * mod);
        ctx.arc(13 * mod, 12 * mod, size / 12, 1.1, 2.5, true);
        ctx.moveTo(10.5 * mod, 12 * mod);
        ctx.arc(10.5 * mod, 12 * mod, size / 12, 1.1, 2.5, true);
        ctx.fill();
        ctx.closePath();
    }
    function drawApple(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2) - 2);

        ctx.fillStyle = "#ff0000";
        ctx.beginPath();
        ctx.arc(size / 2, size / 2 + size / 9, (size / 2.1), Math.PI * 2, -Math.PI * 2, true);
        ctx.fill();
        ctx.closePath();

        ctx.fillStyle = "#ff0000";
        ctx.beginPath();
        ctx.arc(9, size - 3, (size / 4.5), Math.PI * 2, -Math.PI * 2, true);
        ctx.arc(size - 8, size - 3, (size / 4.5), Math.PI * 2, -Math.PI * 2, true);
        ctx.fill();
        ctx.closePath();

        ctx.fillStyle = "black";
        ctx.beginPath();
        ctx.arc(size / 2, size / 6, (size / 7), Math.PI * 2, -Math.PI * 2, true);
        ctx.fill();
        ctx.closePath();

        var mod = size / 23;
        ctx.strokeStyle = "#24da1c";
        ctx.lineWidth = 2;
        ctx.beginPath();

        ctx.beginPath();
        ctx.moveTo(13 * mod + 2, (size / 9) + 4);
        ctx.lineTo( (13 * mod) - (size / 4), (size / 9) + 1);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(13 * mod + 2, (size / 9) + 4);
        ctx.lineTo( (13 * mod) - (size / 2.5), (size / 9) + 3);
        ctx.stroke();

        ctx.strokeStyle = "#bbb";
        ctx.lineWidth = "2";
        ctx.beginPath();
        ctx.moveTo(12, 11);
        ctx.arcTo(5, 11, 5, 30, 7);
        ctx.stroke();



        ctx.closePath();
    }

    function drawOrange(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2) - 1);

        ctx.fillStyle = "#fcb424";
        ctx.beginPath();
        ctx.arc(size / 2, size / 2 + size / 9, (size / 2.2), Math.PI * 2, -Math.PI * 2, true);
        ctx.fill();
        ctx.closePath();

        ctx.fillStyle = "black";
        ctx.beginPath();
        ctx.arc(size / 2, size / 6, (size / 7), Math.PI * 2, -Math.PI * 2, true);
        ctx.fill();
        ctx.closePath();

        var mod = size / 23;
        ctx.strokeStyle = "#24da1c";
        ctx.lineWidth = 2.5;
        ctx.beginPath();
        ctx.moveTo(size / 2, size / 3);
        ctx.lineTo(size / 2, size / 8);
        ctx.lineTo(9 * mod, size / 9);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(9 * mod, (size / 9));
        ctx.lineTo( (9 * mod) + (size / 3), (size / 9) - 2);
        ctx.stroke();

        ctx.closePath();
    }

    function drawStrawberry(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2) + 2);

        ctx.beginPath();
        ctx.fillStyle = "#ff0000";

        ctx.moveTo(size / 2, size - size / 18)
        ctx.bezierCurveTo(0, size / 1.3, 0, -size / 9, size / 2, size / 6)
        ctx.moveTo(size / 2, size - size / 18)
        ctx.bezierCurveTo(size, size / 1.3, size, -size / 9, size / 2, size / 6)

        ctx.fill();
        ctx.closePath();

        ctx.fillStyle = "white";

        ctx.fillRect(size / 4, size / 3, size / 18, size / 16)
        ctx.fillRect(size / 2, size / 4, size / 18, size / 16)
        ctx.fillRect(size - size / 3.5, size / 2.4, size / 18, size / 16)
        ctx.fillRect(size - size / 2.2, size / 2, size / 18, size / 16)
        ctx.fillRect(size / 2.6, size / 1.3, size / 18, size / 16)
        ctx.fillRect(size / 3, size / 1.8, size / 18, size / 16)
        ctx.fillRect(size / 1.6, size / 1.4, size / 18, size / 16)

        ctx.beginPath();
        ctx.fillStyle = "#24DA1D";

        var mod = size / 23;
        ctx.moveTo(6 * mod, 2 * mod);
        ctx.lineTo(1 * mod, 8 * mod);
        ctx.lineTo(6 * mod, 6 * mod);
        ctx.lineTo(11 * mod, 11 * mod);
        ctx.lineTo(16 * mod, 6 * mod);
        ctx.lineTo(21 * mod, 8 * mod);
        ctx.lineTo(17 * mod, 2 * mod);

        ctx.moveTo(size / 2, 2 * mod);
        ctx.lineTo(8 * mod, 0 * mod);
        ctx.lineTo(15 * mod, 0 * mod);
        ctx.lineTo(size / 2, 2 * mod);

        ctx.fill();
        ctx.closePath();
    }
    function drawCherry(ctx, x, y, size) {

        ctx.translate(x - (size / 2), y - (size / 2) + 1);

        ctx.beginPath();
        ctx.fillStyle = "#ff0000";

        ctx.arc(size / 8, size - (size / 2.8), size / 4, Math.PI * 2, -Math.PI * 2, true);
        ctx.arc(size - size / 3, size - (size / 4), size / 4, Math.PI * 2, -Math.PI * 2, true);

        ctx.fill();
        ctx.closePath();

        ctx.beginPath();
        ctx.fillStyle = "#670303";

        ctx.arc(size / 7.2, size - (size / 2.25), size / 14, Math.PI * 2, -Math.PI * 2, true);
        ctx.arc(size - size / 3, size - (size / 3), size / 14, Math.PI * 2, -Math.PI * 2, true);

        ctx.fill();
        ctx.closePath();

        ctx.beginPath();
        ctx.strokeStyle = "#959817";
        ctx.lineWidth = 2;

        ctx.moveTo(size / 8, size - (size / 2));
        ctx.bezierCurveTo(size / 6, size / 1.5, size / 7, size / 4, size - size / 4, size / 8);
        ctx.moveTo(size - size / 2.5, size - size / 3);
        ctx.bezierCurveTo(size / 1.3, size / 1.5, size / 3, size / 2.5, size - size / 4, size / 8);

        ctx.stroke();
        ctx.closePath();

        ctx.fillStyle = "#959817";
        ctx.fillRect(size - size / 3, size / 12, size / 9, size / 9);
        ctx.closePath();
    }


    </script>
    @endsection