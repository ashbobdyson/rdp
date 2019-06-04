<div class="logo">
  <a class="logo-link" href="/portfolio/">
    <span>r</span><span class="collapsable">ich</span>
    <span class="collapsable">&nbsp;</span>
    <span>d</span><span class="collapsable">yson</span>
    <span class="collapsable">&nbsp;</span>
    <span class="photography"><span>p</span><span class="collapsable">hotography</span></span></a>
</div>
<header>
  <div class="main-nav">
      @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'inner-nav']) !!}
    @endif
  </div>
  <div class="contact-item-mob">
      <a href="/contact">Contact</a>
    </div>
</header>

<div class="contact-item">
  <a href="/contact">Contact</a>
</div>
<div class="copyright">
  <p>© rich dyson photography <?= date('Y') ?></p>
</div>
<div class="cart-total-rdp" style="display: none;"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
<div class="mob-bar"><div class="mob-toggle">@include('icons.menu-to-hide')</div></div>
