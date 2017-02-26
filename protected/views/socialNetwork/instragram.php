<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../css/socialNetwork.css" rel="stylesheet" >
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">SocialNetworks</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="">Instagram <span class="sr-only">(current)</span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>

<div class="container" >
    <div class="row">
        <?php if(Yii::app()->getModule('user')->isAdmin()):?>
            <form>
                <input id="instagramName" type="text" name="instagram-username">
                <button type="submit">Search</button>
            </form>
        <?php else: ?>
            <h1>
                You are not an admin son of the bitch!
            </h1>
        <?php endif; ?>

        <div class="start-following-wrapper">
            <button type="button" id="like-btn">Start liking</button>
            <button type="button" id="follow-btn">Start following</button>
        </div>

        <div id="users-list-wrapper">
            <ul id="users-list">

            </ul>
        </div>

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="../../../js/instagramJs.js"></script>

</body>
</html>



