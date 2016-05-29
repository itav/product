<?php $view->extend('layout.php') ?>

<?php $view['slots']->set('title', 'Products') ?>

<h1>
    <?php echo 'Products' ?>
</h1>
<p>
    <?php echo $view->render($form['template'], ['data' => $form]) ?>
</p>
    <script src="/js/itav/main.js" type="text/javascript"></script>
    <script src="/js/itav/test.js" type="text/javascript"></script>
    <script src="/js/itav/offer.js" type="text/javascript"></script>

