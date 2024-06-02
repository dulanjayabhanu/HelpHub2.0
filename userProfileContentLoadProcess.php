<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    $userResultset = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON 
    `user`.`gender_id`=`gender`.`id` WHERE `email`='" . $_SESSION["user"]["email"] . "'");
    $userRownumber = $userResultset->num_rows;

    if ($userRownumber > 0) {
        $userData = $userResultset->fetch_assoc();
?>
        <div class="modal-header border-0">
            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-end pt-3">
                    <button type="button" class="def-dropdown-btn rounded-5 btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="profileModalReset();"></button>
                </div>
                <!-- profile header -->
                <div class="col-12 d-flex flex-row pb-2">
                    <div>
                        <?php
                        $isUserProfileImageSet;
                        $allProfileImageNameArray = scandir("resources/images/profile_images/");
                        $targetProfileImageName = explode("@",$_SESSION["user"]["email"])[0] . ".jpeg";

                        foreach ($allProfileImageNameArray as $imageFileName) {
                            if($imageFileName == $targetProfileImageName){
                                $isUserProfileImageSet = true;
                                break;
                            }else{
                                $isUserProfileImageSet = false;
                            }
                        }

                        if ($isUserProfileImageSet) {
                        ?>
                            <img src="resources/images/profile_images/<?php echo(explode("@",$_SESSION["user"]["email"])[0] . ".jpeg"); ?>" id="main-profile-image" class="profile-wrapper border p-2" alt="profile-image" />
                        <?php
                        } else {
                        ?>
                            <img src="resources/images/profile_images/def-profile.svg" id="main-profile-image" class="profile-wrapper border p-2" alt="profile-image" />
                        <?php
                        }
                        ?>
                    </div>
                    <div class="my-auto ps-2 d-flex flex-column">
                        <div class="col-12 p-0 m-0">
                            <span class="profile-name-header text-capitalize" id="profile-header-main-name"><?php echo ($userData["first_name"] . " " . $userData["last_name"]); ?></span>
                        </div>
                        <div class="col-12 d-flex flex-column">
                            <span class="fs-5 profile-header-username" id="profile-header-main-username">@<?php echo ($userData["username"]); ?></span>
                            <label type="button" for="profile-image-uploader" class="def-btn1 disabled-btn mt-2 ps-3 pe-3 profile-image-change-btn my-auto" require onclick="changeUserProfileImage();"><i class="bi bi-pencil-square"></i> Change Profile</label>
                            <input type="file" class="d-none" id="profile-image-uploader" accept=".png, .jpg, .jpeg" />
                        </div>
                    </div>
                </div>
                <!-- profile header -->
            </div>
        </div>
        <div class="modal-body modal-content-wrapper">
            <div class="row">
                <!-- user profile detail section -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 pe-1 p-0 m-0">
                            <div class="col-12 def-input rounded-5 p-2">
                                <div class="row ps-3 pe-3 pt-2 pb-2">
                                    <div class="col-12">
                                        <span class="def-input-text">First Name<span class="required-symbol"> *</span></span>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" value="<?php echo ($userData["first_name"]); ?>" onchange="errorReset('update-profile-error-loader','profile-update-btn');" id="profile-first-name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ps-1 p-0 m-0">
                            <div class="col-12 def-input rounded-5 p-2">
                                <div class="row ps-3 pe-3 pt-2 pb-2">
                                    <div class="col-12">
                                        <span class="def-input-text">Last Name<span class="required-symbol"> *</span></span>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" value="<?php echo ($userData["last_name"]); ?>" onchange="errorReset('update-profile-error-loader','profile-update-btn');" id="profile-last-name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text" id="bio-text">Bio</span>
                                </div>
                                <div class="col-12 pt-1">
                                    <textarea class="def-input-modify pt-1 pb-1 pe-2" cols="10" rows="3" placeholder="Type here..." type="text" onkeyup="textLimitIndicate('bio','160');" onchange="errorReset('update-profile-error-loader','profile-update-btn');" id="bio"><?php echo ($userData["bio"]); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text">Username<span class="required-symbol"> *</span></span>
                                </div>
                                <div class="col-12 pt-1">
                                    <input class="def-input-modify pt-1 pb-1 pe-2" type="text" value="<?php echo ($userData["username"]); ?>" id="profile-username" onchange="errorReset('update-profile-error-loader','profile-update-btn');" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text">Mobile<span class="required-symbol"> *</span></span>
                                </div>
                                <div class="col-12 pt-1">
                                    <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" onchange="errorReset('update-profile-error-loader','profile-update-btn');" id="profile-mobile" value="<?php echo ($userData["mobile"]); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text">Email<span class="required-symbol def-link"> &#40;disabled&#41;</span></span>
                                </div>
                                <div class="col-12 pt-1">
                                    <input class="def-input-modify pt-1 pb-1 pe-2" disabled type="email" value="<?php echo ($userData["email"]); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text">Password<span class="required-symbol"> *</span></span>
                                </div>
                                <div class="col-12 pt-1 d-flex flex-row">
                                    <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="password" onchange="errorReset('update-profile-error-loader','profile-update-btn');" id="profile-password" value="<?php echo ($userData["password"]); ?>" />
                                    <button class="bg-transparent border-0" id="password-status-change-btn4" onclick="passwordFieldHideStatusShift('profile-password','password-status-change-btn4');"><i class="bi bi-eye-slash def-input-text fs-5"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 def-input rounded-5 p-2 mt-3">
                            <div class="row ps-3 pe-3 pt-2 pb-2">
                                <div class="col-12">
                                    <span class="def-input-text">Gender<span class="required-symbol def-link"> &#40;disabled&#41;</span></span>
                                </div>
                                <div class="col-12 pt-1">
                                    <select disabled class="def-input-modify border-0">
                                        <option><?php echo ($userData["g_name"]); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- user profile detail section -->
            </div>
        </div>
        <div class="modal-footer border-0 d-flex flex-row justify-content-center">
            <div class="col-12 my-auto" id="update-profile-error-loader">
            </div>
            <div class="col-12 col-md-10 col-lg-6">
                <button type="button" id="profile-update-btn" class="def-btn1 ps-3 pe-3 pt-2 pb-2 w-100 disabled-btn" disabled onclick="userProfileUpdate();">Update</button>
            </div>
        </div>
<?php
    } else {
        echo ("user rejected");
    }
} else {
    echo ("user rejected");
}
?>