<?php
    $pageUrl = str_replace('http://'.$_SERVER['SERVER_NAME'], '', url()->current());
?>
<div class="top-section">
    <div class="pull-right">
        phone
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link {{ $pageUrl == '/page/o-kompanii' ? 'active' : '' }}" href="/page/o-kompanii">О компании</a>
            </li>
            <li class="nav-item dropdown {{ $pageUrl == '/page/soprovozhdenie-proektov'
            || $pageUrl == '/page/konsultacii' || $pageUrl == '/page/privlechenie-investiciy' ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Услуги
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item " href="/page/soprovozhdenie-proektov">Сопровождение проектов</a>
                    <a class="dropdown-item" href="/page/konsultacii">Консультации</a>
                    <a class="dropdown-item" href="/page/privlechenie-investiciy">Привлечение инвестиций</a>
                </div>
            </li>
            <li class="nav-item dropdown {{ $pageUrl == '/page/chto-takoe-gchp'
            || $pageUrl == '/page/zakonodatelstvo'
            || $pageUrl == '/page/publikacii'
            || $pageUrl == '/page/mezhdunarodnyy-opyt' ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    О ГЧП
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/page/chto-takoe-gchp">Что такое ГЧП</a>
                    <a class="dropdown-item" href="/page/zakonodatelstvo">Законодательство</a>
                    <a class="dropdown-item" href="/page/publikacii">Публикации</a>
                    <a class="dropdown-item" href="/page/mezhdunarodnyy-opyt">Международный опыт</a>
                </div>
            </li>
            <li class="nav-item dropdown {{ $pageUrl == '/page/baza-proektov'
            || $pageUrl == '/news' ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Проекты
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/page/baza-proektov">База проектов</a>
                    <a class="dropdown-item" href="/news">Новости</a>
                </div>
            </li>
            <li class="nav-item {{ $pageUrl == '/contacts' ? 'active' : '' }}">
                <a class="nav-link" href="/contacts">Контакты</a>
            </li>
        </ul>
    </div>
</nav>