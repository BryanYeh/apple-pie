<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Edit Profile <?php echo $data['username']; ?></h1>
            <hr>

            <p>If you have an account, sign in with your username.</p>
            <form role="form" id="login" name="login" method="post">
                <div class="form-group">
                    <label for="username">First Name: </label><span class="label label-danger pull-right">Required</span>
                    <input id="username" type="text" class="form-control" name="username" placeholder="Enter your Name">
                </div>
                <div class='form-group'>
                    <select class='form-control' id='gender' name='gender'>
                        <option value='male' <?php if($data['profile']->gender == "Male") echo "selected";?> >Male</option>
                        <option value='female' <?php if($data['profile']->gender == "Female") echo "selected";?> >Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Website: </label><span class="label label-danger pull-right">Required</span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label for="email">Fake Image: </label><span class="label label-danger pull-right">Required</span>
                    <img alt="User Pic" src="http://www.userapplepie.com/content/profile/small/UserApplePie_1_b3o7orlr2cv3jic121320431.jpg" class="img-circle img-responsive" style="overflow:hidden">
                </div>
                <?php if($data['profile']->userImage != ""){ ?>
                <div class="form-group">
                    <label for="email">Real Image: </label><span class="label label-danger pull-right">Required</span>
                    <img alt="User Pic" src="http://www.userapplepie.com/content/profile/small/UserApplePie_1_b3o7orlr2cv3jic121320431.jpg" class="img-circle img-responsive" style="overflow:hidden">
                </div>
                <?php } ?>
                <div class="form-group">
                    <label class="control-label">Picture</label>
                    <input type="file" class="form-control" accept="image/jpeg" id="picture[1]" name="picture[1]">
                </div>
                <div class="form-group">
                    <label for="email">Profile: </label><span class="label label-danger pull-right">Required</span>
                    <textarea id="password"  class="form-control" name="password" placeholder="Enter Profile"></textarea>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>" />
                <input type="submit" name="submit" class="btn btn-primary" value="Login">
            </form>
        </div>
    </div>
</div>