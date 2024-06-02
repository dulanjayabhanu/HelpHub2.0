<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    if (isset($_POST["recvrMl"]) & !empty($_POST["recvrMl"])) {
        $userResultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $_POST["recvrMl"] . "'");
        $userRownumber = $userResultset->num_rows;

        if ($userRownumber > 0) {
            $userData = $userResultset->fetch_assoc();
?>
            <div class="modal-header border-0">
                <div class="row w-100">
                    <div class="col-12 d-flex flex-row justify-content-end pt-1s w-100">
                        <button type="button" class="def-dropdown-btn rounded-5 btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="chatContentLoadStop();shortMessageLoadStop();messageModalReset();"></button>
                    </div>
                    <!-- message profile header -->
                    <div class="col-12 d-flex flex-row pb-1">
                        <div>
                            <?php
                            $isUserProfileImageSet;
                            $allProfileImageNameArray = scandir("resources/images/profile_images/");
                            $targetProfileImageName = explode("@", $userData["email"])[0] . ".jpeg";

                            foreach ($allProfileImageNameArray as $imageFileName) {
                                if ($imageFileName == $targetProfileImageName) {
                                    $isUserProfileImageSet = true;
                                    break;
                                } else {
                                    $isUserProfileImageSet = false;
                                }
                            }

                            if ($isUserProfileImageSet) {
                            ?>
                                <img src="resources/images/profile_images/<?php echo ($targetProfileImageName); ?>" id="main-profile-image" class="profile-wrapper message-main-profile-modify border p-2" alt="profile-image" />
                            <?php
                            } else {
                            ?>
                                <img src="resources/images/profile_images/def-profile.svg" id="main-profile-image" class="profile-wrapper message-main-profile-modify border p-2" alt="profile-image" />
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
                            </div>
                        </div>
                    </div>
                    <!-- message profile header -->
                </div>
            </div>
            <div class="modal-body modal-content-wrapper">
                <div class="row">
                    <!-- message chat section -->
                    <div class="col-12">
                        <div class="row" id="private-chat-loading-area">
                            <!-- chat per-loading card -->
                            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                <div class="spinner-border def-modal-spinner mt-5" role="status"></div>
                                <span class="mb-5">Chat loading...</span>
                            </div>
                            <!-- chat per-loading card -->
                        </div>
                    </div>
                    <!-- message chat section -->
                </div>
            </div>
            <div class="modal-footer border-0 d-flex flex-row justify-content-center">
                <div class="col-12 my-auto" id="private-chat-error-loader">
                </div>
                <div class="col-12 d-flex flex-row gap-3">
                    <input type="text" placeholder="Type your reply..." class="pt-1 pb-1 def-input-modify" id="private-chat-text" />
                    <div>
                        <div class="dropdown dropup">
                            <button class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-emoji-smile fs-5" data-bs-toggle="tooltip" data-bs-title="Emoji" data-bs-custom-class="custom-tooltip"></i>
                                <span class="position-absolute top-0 start-100 translate-middle rounded-pill badge-modify ps-1 pe-1">New</span>
                            </button>
                            <ul class="dropdown-menu def-dropdown-menu p-2 mt-2 shadow">
                                <li class="my-auto">
                                    <div class="col-12 p-2">
                                        <div class="row modal-content-wrapper d-flex flex-row justify-content-center emoji-content-wrapper">
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128512;');">&#128512;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128513;');">&#128513;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128514;');">&#128514;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128515;');">&#128515;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128516;');">&#128516;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128517;');">&#128517;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128518;');">&#128518;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128519;');">&#128519;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128522;');">&#128522;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128523;');">&#128523;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128524;');">&#128524;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128525;');">&#128525;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128526;');">&#128526;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128528;');">&#128528;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128529;');">&#128529;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128532;');">&#128532;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128534;');">&#128534;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128536;');">&#128536;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128546;');">&#128546;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128557;');">&#128557;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128561;');">&#128561;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128564;');">&#128564;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128566;');">&#128566;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128567;');">&#128567;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128578;');">&#128578;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#128512;');">&#128512;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129300;');">&#129300;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129321;');">&#129321;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129395;');">&#129395;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129398;');">&#129398;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129402;');">&#129402;</button>
                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('private-chat-text','&#129488;');">&#129488;</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center ps-3 pe-3" onclick="saveChat('<?php echo ($_POST['recvrMl']); ?>');"><i class="bi bi-send-fill"></i></button>
                </div>
            </div>
<?php
        } else {
            echo ("Something went wrong");
        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("user rejected");
}
?>