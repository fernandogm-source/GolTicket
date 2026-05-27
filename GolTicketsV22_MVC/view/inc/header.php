<div id="header">
    <div class="header-inner">

        <!-- Logo -->
        <a class="header-logo" href="index.php">
            <div class="logo-icon">
                <span class="material-symbols-outlined">confirmation_number</span>
            </div>
            <span class="logo-text">Gol<span class="logo-accent">Ticket</span></span>
        </a>

        <!-- Buscador -->
        <div class="header-search">
            <div class="search-wrapper">
                <span class="material-symbols-outlined search-icon">search</span>
                <input id="header-search-input" class="search-input" type="text"
                       placeholder="Buscar eventos, equipos o ciudades..."
                       autocomplete="off"/>
                <div id="header-search-dropdown" class="search-dropdown" style="display:none;"></div>
            </div>
        </div>

        <!-- Navegación -->
        <nav class="header-nav">
            <a href="index.php?page=controller_shop&op=view">Shop</a>

            <!-- Botón acceder (sin sesión) -->
            <a href="index.php?page=controller_auth&op=view" class="btn-signin" id="signin">Acceder</a>

            <!-- Perfil de usuario (con sesión) -->
            <div class="user-menu" id="user-menu" style="display:none;">
                <div class="log-icon"></div>
                <div id="des_inf_user">
                    <p id="user_info"></p>
                </div>
            </div>
        </nav>

    </div>
</div>
