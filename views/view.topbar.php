<div class="topbar-one">
    <div class="container-fluid">
        <div class="topbar-one__inner">
            <ul class="list-unstyled topbar-one__info">
                <li class="topbar-one__info__item">
                    <i class="fas fa-map-marker topbar-one__info__icon"></i>
                    <a href="https://www.google.com/maps">Midigama, Sri Lanka</a>
                </li>
                <li class="topbar-one__info__item">
                    <i class="fas fa-envelope topbar-one__info__icon"></i>
                    <a href="mailto:needhelp@company.com">info@gunasenavilla.com</a>
                </li>
                <li class="topbar-one__info__item">
                    <i class="fas fa-phone-square topbar-one__info__icon"></i>
                    <a href="tel:+94757856219">+ 94 75 785 6219</a>
                </li>
                <?php if($users->isLogged()): ?>
                <li class="topbar-one__info__item">
                    <a href="edit-profile.php" class="thm-btn">Update Profile</a>
                </li>
                <li class="topbar-one__info__item">
                    <a href="change-password.php" class="thm-btn">Change Password</a>
                </li>
                <?php endif; ?>
                <?php if($users->isAdmin()): ?>
                <li class="topbar-one__info__item">
                    <a href="admin/" class="thm-btn">Admin Area</a>
                </li>
                <?php endif; ?>
            </ul><!-- /.list-unstyled topbar-one__info -->
            <div class="topbar-one__right">
                <div class="topbar-one__social">
                    <a href="https://twitter.com/">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                        <span class="sr-only">Twitter</span>
                    </a>
                    <a href="https://facebook.com/">
                        <i class="fab fa-facebook" aria-hidden="true"></i>
                        <span class="sr-only">Facebook</span>
                    </a>
                    <a href="https://pinterest.com/">
                        <i class="fab fa-pinterest-p" aria-hidden="true"></i>
                        <span class="sr-only">Pinterest</span>
                    </a>
                    <a href="https://instagram.com/">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                        <span class="sr-only">Instagram</span>
                    </a>
                </div><!-- /.topbar-one__social -->
            </div><!-- /.topbar-one__right -->
        </div><!-- /.topbar-one__inner -->
    </div><!-- /.container-fluid -->
</div><!-- /.topbar-one -->