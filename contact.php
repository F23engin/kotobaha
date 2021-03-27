<!--  -->
<?php
session_start();
$mode = 'input';
$errmessage = array();
if( isset($_POST['back']) && $_POST['back'] ){
  // no action
} else if( isset($_POST['confirm']) && $_POST['confirm'] ){
  // confirm page
  if( !$_POST['fullname'] ) {
    $errmessage[] = "お名前を入力してください。";
  } else if( mb_strlen($_POST['fullname']) > 100 ){
    $errmessage[] = "お名前は100文字以内で入力してください。";
  }
  $_SESSION['fullname']	= htmlspecialchars($_POST['fullname'], ENT_QUOTES);

  if( !$_POST['email'] ) {
    $errmessage[] = "メールアドレスを入力してください。";
  } else if( mb_strlen($_POST['email']) > 200 ){
    $errmessage[] = "メールアドレスは200文字以内で入力してください。";
  } else if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
    $errmessage[] = "メールアドレスが不正です。";
  }
  $_SESSION['email']	= htmlspecialchars($_POST['email'], ENT_QUOTES);

  if( !$_POST['message'] ){
    $errmessage[] = "お問い合わせ内容を入力してください。";
  } else if( mb_strlen($_POST['message']) > 2000 ){
    $errmessage[] = "お問い合わせ内容は2000文字以内で入力してください。";
  }
  $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);

  if( $errmessage ){
    $mode = 'input';
  } else {
    //$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); // php5のとき
    $token = bin2hex(random_bytes(32));                          // php7以降
    $_SESSION['token']  = $token;
    $mode = 'confirm';
  }
} else if( isset($_POST['send']) && $_POST['send'] ){
  // pushed send-btn
  if( !$_POST['token'] || !$_SESSION['token'] || !$_SESSION['email'] ){
    $errmessage[] = '不正な処理が行われました';
    $_SESSION     = array();
    $mode         = 'input';
  } else if( $_POST['token'] != $_SESSION['token'] ){
    $errmessage[] = '不正な処理が行われました';
    $_SESSION     = array();
    $mode         = 'input';
  } else {
    $message = "お問い合わせの受け付けが完了いたしました。 \r\n". "\r\n". "\r\n". "\r\n". "\r\n"
               . "お名前:" . "\r\n" . $_SESSION['fullname'] . "\r\n" . "\r\n"
               . "メールアドレス:" . "\r\n" . $_SESSION['email'] . "\r\n" . "\r\n"
               . "お問い合わせ内容:" . "\r\n"
               . preg_replace( "/\r\n|\r|\n/", "\r\n", $_SESSION['message'] )
               . "\r\n". "\r\n". "\r\n". "\r\n". "\r\n"
               ."コトバハ——". "\r\n"
               ."kotobaha.com";
    mail( $_SESSION['email'], 'お問い合わせいただきありがとうございます。', $message );
    mail( 'kotobaha.official@gmail.com', 'お問い合わせいただきありがとうございます。', $message );
    $_SESSION = array();
    $mode     = 'send';
  }
} else {
  // GET
  $_SESSION['fullname'] = "";
  $_SESSION['email']    = "";
  $_SESSION['message']  = "";
}

?>

<!-- html -->
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no, email=no, address=no">
<link rel="icon" href="/images/kotobaha-logo-icon.svg">
    
<meta property="og:url" content="kotobaha.com">
<meta property="og:type" content="">
<meta property="og:title" content="コトバハ——">
<meta property="og:description" content="コトバハ——|お問い合わせ">
<meta property="og:site_name" content="コトバハ——">
<meta property="og:image" content="/images/kotobaha-logo-icon.svg">
<meta property="og:local" content="ja_JP">
<meta name="twitter:" content="summaary_large_image">
<meta name="twitter:site" content="@kotobaha1">
    
<title>コトバハ——|お問い合わせ</title>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CK7J60B1XH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CK7J60B1XH');
</script>

    
<!-- header font -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<!-- main font -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@100;300;400;500;700&display=swap" rel="stylesheet">
<!-- title + nav font -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    
<link rel="stylesheet" href="/css/sanitize.css">
<link rel="stylesheet" href="/css/my_reset.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/contact.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="/index.html"><img src="/images/kotobaha-logo-icon.svg" alt="" class="logo__img"></a>
        </div>
        <div class="back-top-page">
            <a href="/index.html"><img src="/images/back-top-page.svg" alt="" class="back-top-page__img"></a>
        </div>
        <div class="sns">
            <a class="sns__link" href="https://twitter.com/kotobaha1"><img class="sns__link-img" src="/images/twitter.svg" alt=""></a>
        </div>
    </header>
    <main>

        <?php if( $mode == 'input' ){ ?>
        <!-- input page -->
        <?php
        if( $errmessage ){
            echo '<div class="danger-alert" role="alert">';
            echo implode('<br>', $errmessage );
            echo '</div>';
        }
        ?>
        <h1>お問い合わせフォーム</h1>
        <section class="contact">
            <div class="contact__flex-container">
                <div class="contact__form">
                    <form action="/contact.php" method="post" name="contactForm">
                        <ul class="form__list">
                            <li class="form__item">
                                <label for="fullname">
                                    <span>お名前</span>
                                    <input type="text" name="fullname" id="formName" required="true" maxlength="100" placeholder="ご応募の場合のみペンネーム可" value="<?php echo $_SESSION['fullname'] ?>" >
                                </label>
                            </li>
                            <li class="form__item">
                                <label for="email">
                                    <span>メールアドレス</span>
                                    <input type="email" name="email" id="formMail" required="true" placeholder="xxxxx@mail.com" value="<?php echo $_SESSION['email'] ?>">
                                </label>
                            </li>
                            <li class="form__item">
                                <label for="message">
                                    <span>お問い合わせ内容</span>
                                    <textarea name="message" id="formText" cols="30" rows="10" maxlength="2000" required="true" placeholder="最大2000文字まで"><?php echo $_SESSION['message'] ?></textarea>
                                </label>
                            </li>
                        </ul>
                        <div class="form__button">
                            <input class="form__submit" type="submit" name="confirm" value="入力内容を確認" id="btn">
                        </div>
                    </form>
                </div>
                <div class="contact__flex-item">
                    <p class="contact__text">
                        <a href="https://twitter.com/kotobaha1" class="contact__link"><span class="contact__link-text">Twitterのダイレクトメール</span></a><br>
                        からもお問い合わせいただけます。
                    </p>
                </div>
            </div>
        </section>
        <?php } else if( $mode == 'confirm' ){ ?>
        <!-- confirm page -->
        <h1>お問い合わせ内容のご確認</h1>
        <section class="contact">
          <div class="contact__form">
            <form action="/contact.php" method="post" id="contactForm">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <span class="confirm-name">お名前</span>
                <p class="confirm-input"><?php echo $_SESSION['fullname'] ?></p>
                <span class="confirm-name">メールアドレス</span>
                <p class="confirm-input"><?php echo $_SESSION['email'] ?></p>
                <span class="confirm-name">お問い合わせ内容</span>
                <p class="confirm-input"><?php echo nl2br($_SESSION['message']) ?></p>
                <input type="submit" name="back" value="戻る" class="back-btn">
                <input type="submit" name="send" value="送信" class="send-btn">
            </form>
          </div>
        </section>
        <?php } else { ?>
        <!-- thanks page -->
        <section class="contact">
          <p class="thanks__text">内容の送信が完了いたいました。<br>お問い合わせいただきありがとうございました。</p>
          <div>
              <a href="/index.html" class="thanks__link-top-page">トップページへ</a>
          </div>
        </section>
        <?php } ?>
    </main>
    <footer class="footer">
        <img src="/images/kotobaha-logo-02.svg" alt="" class="footer__logo">
        <span class="footer__title">コトバハ<span class="footer__title-dash">——</span></span>
        <span class="footer__pc-title">コトバハ<span class="footer__title-dash">——</span></span>

        <div class="credit-title-and-copyright">
            <span class="designer">design by <a href="https://fumiakishishido.com" class="designer-name">Fumiaki Shishido</a></span>
            <span class="copyright">©︎ kotobaha——</span>
        </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="/script/script.js"></script>
    <script type="text/javascript" src="/script/form.js"></script>
</body>

</html>


