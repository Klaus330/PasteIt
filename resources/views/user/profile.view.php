<?php
$this->setTitle("Profile");
?>
<div class="flex">
    <section class="section">
        <div class="row">
            <h4 class="section-title mb-2 h4">My Profile</h4>
            <div class="settings-content">
                <?php $form = \app\forms\Form::begin('/user/profile', "POST", "home-form") ?>
                <?= $form->inputField(auth(), 'username') ?>
                <?= $form->inputField(auth(),"email")->emailField() ?>


                    <div class="grid">
                        <div class="col-4 col-md-3 flex align-start">
                            <label class="form-label" for="avatar">Avatar : </label>
                        </div>
                        <div class="col-1 col-md-3 flex align-start" >
                            <img class="profile-img" src="<?= !empty(auth()->avatar) ? auth()->avatar : 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50'?>" alt="user icon"/>
                        </div>
                        <div class="col-6 col-md-4 flex align-start">
                                <input type="file" name="avatar" id="avatar"/>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-5 col-md-3 flex align-start">
                            <label class="form-label" for="theme-mode">Theme : </label>
                        </div>
                        <div class="col-7 col-md-6 flex align-center">
                            <img src="/img/svg/sun.svg" alt="Sun" />
                            <input class="swipe-btn" type="checkbox" id="theme-mode" <?= $isInputChecked ? 'checked' : '' ?> />
                            <img src="/img/svg/moon.svg " alt="Moon" />
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12 col-md-3 mt-5 flex align-start">
                            <button type="submit" class="btn btn-dark">Update Settings</button>
                        </div>
                    </div>
                <?php \app\forms\Form::end() ?>
                <?php include("../resources/views/partials/related-links.view.php")?>
            </div>
        </div>

    </section>


    <aside class="home-aside sm-hidden settings-aside">
        <h4 class="h4">Public Pastes</h4>
        <ul class="list-group">
            <?php foreach ($latestPastes as $paste): ?>
                <li class="list-group-item">
                    <a href="/paste/view/<?= $paste->slug ?>"><?= $paste->title ?></a>
                    <span><?= $paste->syntax()->name ?> | <?= $paste->timeSinceCreation() ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

</div>

<script>

    function setThemeCookie(e) {
        let event = new Event("theme-changed");
        event.initEvent('theme-changed', true, true);
        document.cookie = "theme=;expires=Thu, 18 Dec 2021 12:00:00 UTC;path=/";

        let body = document.getElementsByTagName('body')[0];
        let currentTheme = body.classList[0];
        console.log(currentTheme);
        if (e.target.checked  && currentTheme === 'light') {
            document.cookie = "theme=dark;expires=Thu, 18 Dec 2021 12:00:00 UTC;path=/";
        } else if (e.target.checked  && currentTheme === 'dark') {
            document.cookie = "theme=light;expires=Thu, 18 Dec 2021 12:00:00 UTC;path=/";
        }else if (!e.target.checked  && currentTheme === 'light'){
            document.cookie = "theme=dark;expires=Thu, 18 Dec 2021 12:00:00 UTC;path=/";
        }else if (!e.target.checked  && currentTheme === 'dark'){
            document.cookie = "theme=light;expires=Thu, 18 Dec 2021 12:00:00 UTC;path=/";
        }
        body.dispatchEvent(event);
    }

    function changeTheme(e) {
        let cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            if (cookies[i].split('=')[0].trim() === 'theme') {
                let themeValue = cookies[i].split('=')[1];
                e.target.classList = '' + themeValue;
            }
        }


    }

    document.getElementById('theme-mode')?.addEventListener('click', setThemeCookie);

    document.getElementsByTagName('body')[0].addEventListener('theme-changed', changeTheme);

</script>


