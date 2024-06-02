const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

var isOperationValied = true;

function collapseIconToggler(id, innerContent) {
    var collapseBtn = document.getElementById(id);

    if (collapseBtn.innerHTML == innerContent + '&nbsp;&nbsp;<i class="bi bi-chevron-up"></i>') {
        collapseBtn.innerHTML = innerContent + '&nbsp;&nbsp;<i class="bi bi-chevron-down"></i>';
    } else if (collapseBtn.innerHTML == innerContent + '&nbsp;&nbsp;<i class="bi bi-chevron-down"></i>') {
        collapseBtn.innerHTML = innerContent + '&nbsp;&nbsp;<i class="bi bi-chevron-up"></i>';
    }
    isOperationValied = true;
}

function collapseIconTogglerStart(id, innerContent) {
    if (isOperationValied) {
        isOperationValied = false;
        collapseIconToggler(id, innerContent);
    }
}

function passwordFieldHideStatusShift(componentId, btnId) {
    var component = document.getElementById(componentId);
    var button = document.getElementById(btnId);

    if (component.type == "text") {
        component.type = "password";
        button.innerHTML = "<i class='bi bi-eye-slash def-input-text fs-5'></i>"
    } else if (component.type == "password") {
        component.type = "text";
        button.innerHTML = "<i class='bi bi-eye def-input-text fs-5'></i>"
    }
}

function showModal(id) {
    var m = document.getElementById(id);
    bm = new bootstrap.Modal(m);
    bm.show();
}

function showToast(msg) {
    var toast1 = document.getElementById("toast1");
    toast1 = new bootstrap.Toast(toast1);
    document.getElementById("toast-messag").innerHTML = msg;

    toast1.show();
}

function sectionShift() {
    var signUpSection = document.getElementById("signup-section");
    var signInSection = document.getElementById("signin-section");
    var signInButton = document.getElementById("signin-btn");
    var signUpButton = document.getElementById("signup-btn");

    signUpSectionReset();
    signInSectionReset();
    signUpSection.classList.toggle("d-none");
    signInSection.classList.toggle("d-none");
    signInButton.classList.toggle("d-none");
    signUpButton.classList.toggle("d-none");
}

function forgotPasswordSectionShift(isShiftingBackward) {
    var signInSection = document.getElementById("signin-section");
    var passwordResetSection = document.getElementById("password-reset-section");

    var signInButton = document.getElementById("signin-btn");
    var passwordResetButton = document.getElementById("password-reset-btn");

    if (isShiftingBackward == "true") {
        var signUpSection = document.getElementById("signup-section");
        var signUpButton = document.getElementById("signup-btn");

        signUpSectionReset();
        forgotPasswordSectionReset();
        passwordResetSection.classList.toggle("d-none");
        passwordResetButton.classList.toggle("d-none");
        signUpSection.classList.toggle("d-none");
        signUpButton.classList.toggle("d-none");

    } else if (isShiftingBackward == "false") {
        signInSectionReset();
        forgotPasswordSectionReset();
        signInSection.classList.toggle("d-none");
        passwordResetSection.classList.toggle("d-none");
        signInButton.classList.toggle("d-none");
        passwordResetButton.classList.toggle("d-none");
    }
}

function modalReset() {
    var signUpSection = document.getElementById("signup-section");
    var signInSection = document.getElementById("signin-section");
    var passwordResetSection = document.getElementById("password-reset-section");

    var signInButton = document.getElementById("signin-btn");
    var signUpButton = document.getElementById("signup-btn");
    var passwordResetButton = document.getElementById("password-reset-btn");

    if (signInSection.className.includes("d-none")) {
        signInSection.classList.toggle("d-none");
        signInButton.classList.toggle("d-none");
    } else {
        signInSectionReset();
    }

    if (!signUpSection.className.includes("d-none")) {
        signUpSectionReset();
        signUpSection.classList.toggle("d-none");
        signUpButton.classList.toggle("d-none");
    }

    if (!passwordResetSection.className.includes("d-none")) {
        forgotPasswordSectionReset();
        passwordResetSection.classList.toggle("d-none");
        passwordResetButton.classList.toggle("d-none");
    }
}

function profileModalReset() {
    document.getElementById("profile-detail-components-loader").innerHTML = "";
    document.getElementById("update-profile-error-loader").innerHTML = "";

    document.getElementById("profile-update-btn").disabled = true;
    document.getElementById("profile-update-btn").classList.add("disabled-btn");
    document.getElementById("update-profile-error-loader").innerHTML = "";
}

function messageModalReset() {
    document.getElementById("private-chat-loading-area").innerHTML = "";
    document.getElementById("private-chat-text").innerHTML = "";
}

function signUp() {
    var firstName = document.getElementById("first-name");
    var lastName = document.getElementById("last-name");
    var username = document.getElementById("username");
    var mobile = document.getElementById("mobile");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var gender = document.getElementById("gender");

    var form = new FormData();
    form.append("firstName", firstName.value);
    form.append("lastName", lastName.value);
    form.append("username", username.value);
    form.append("mobile", mobile.value);
    form.append("email", email.value);
    form.append("password", password.value);
    form.append("gender", gender.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> Account Created</span>";
                signUpSectionReset();

                setTimeout(sectionShift, 1000);
                setTimeout(signUpSuccessMessageRemove, 15000);
            } else {
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("signup-btn").disabled = true;
                document.getElementById("signup-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "userSignUpProcess.php", true);
    request.send(form);
}

function signUpSectionReset() {
    var firstName = document.getElementById("first-name");
    var lastName = document.getElementById("last-name");
    var username = document.getElementById("username");
    var mobile = document.getElementById("mobile");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var gender = document.getElementById("gender");

    firstName.value = "";
    lastName.value = "";
    username.value = "";
    mobile.value = "";
    email.value = "";
    password.value = "";
    gender.value = "0";
    document.getElementById("signup-btn").disabled = true;
    document.getElementById("signup-btn").classList.add("disabled-btn");
    document.getElementById("sign-up-error-loader").innerHTML = "";
}

function signInSectionReset() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");

    username.value = "";
    password.value = "";

    document.getElementById("signin-btn").disabled = true;
    document.getElementById("signin-btn").classList.add("disabled-btn");
    document.getElementById("sign-up-error-loader").innerHTML = "";
}

function forgotPasswordSectionReset() {
    var verificationCode = document.getElementById("verification-code");
    var newPassword = document.getElementById("new-password");

    verificationCode.value = "";
    newPassword.value = "";

    document.getElementById("password-reset-btn").disabled = true;
    document.getElementById("password-reset-btn").classList.add("disabled-btn");
    document.getElementById("sign-up-error-loader").innerHTML = "";
}

function errorReset(id, btnId) {
    document.getElementById(btnId).disabled = false;
    document.getElementById(btnId).classList.remove("disabled-btn");
    document.getElementById(id).innerHTML = "";
}

function signUpSuccessMessageRemove() {
    document.getElementById("sign-up-error-loader").innerHTML = "";
}

function profileUpdateMessageRemove() {
    document.getElementById("update-profile-error-loader").innerHTML = "";
}

function signIn() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                signInSectionReset();
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> Sign In Successfull</span>";

                setTimeout(pageRedirect, 3000);
            } else {
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("signup-btn").disabled = true;
                document.getElementById("signup-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "userSignInProcess.php", true);
    request.send(form);
}

function pageRedirect() {
    window.location.reload();
}

function forgotPasswordSendingAreaShift() {
    document.getElementById("forgot-password-sending-loader").classList.toggle("d-none");
}

function sendVerificationCode() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");

    var currecentUsername = username.value;

    var form = new FormData();
    form.append("username", username.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                forgotPasswordSendingLoaderShift();
                forgotPasswordSectionShift("false");
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> Verification code send successfull</span>";
                password.value = "";
                username.value = currecentUsername;
                setTimeout(signUpSuccessMessageRemove, 15000);
            } else {
                forgotPasswordSendingLoaderShift();
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("signup-btn").disabled = true;
                document.getElementById("signup-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "sendVerificationCode.php", true);
    request.send(form);
}

function updatePassword() {
    var username = document.getElementById("username2");
    var verificationCode = document.getElementById("verification-code");
    var newPassword = document.getElementById("new-password");

    var currecentUsername = username.value;

    var form = new FormData();
    form.append("verificationCode", verificationCode.value);
    form.append("newPassword", newPassword.value);
    form.append("username", username.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                forgotPasswordSectionShift("false");
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> New password updated</span>";
                password.value = "";
                username.value = currecentUsername;
                setTimeout(signUpSuccessMessageRemove, 15000);
            } else {
                document.getElementById("sign-up-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("signup-btn").disabled = true;
                document.getElementById("signup-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "updateUserPassword.php", true);
    request.send(form);
}

function forgotPasswordSendingLoaderShift() {
    document.getElementById("forgot-password-sending-loader").classList.toggle("d-none");
}

function updateFollowingCategory(id, btnId) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "category removed") {
                document.getElementById("following-category-btn" + btnId).classList.remove("def-btn2");
                document.getElementById("following-category-btn" + btnId).classList.add("comment-btn");
                showToast(text);
                mainPostPreLoader();
            } else if (text == "category added") {
                document.getElementById("following-category-btn" + btnId).classList.add("def-btn2");
                document.getElementById("following-category-btn" + btnId).classList.remove("comment-btn");
                showToast(text);
                mainPostPreLoader();
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 3000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("GET", "updateFollowingCategoryProcess.php?ctgId=" + id, true);
    request.send();
}

function signOut() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                setTimeout(showToast("You are sign out"), 4000);
                setTimeout(pageRedirect, 3000);
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 3000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("GET", "signOutProcess.php", true);
    request.send();
}

function userProfileContentLoad() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 3000);
            } else {
                document.getElementById("profile-detail-components-loader").innerHTML = text;
                showModal("modal2");
            }
        }
    };

    request.open("GET", "userProfileContentLoadProcess.php", true);
    request.send();
}

function changeUserProfileImage() {
    var imageUploader = document.getElementById("profile-image-uploader");

    imageUploader.onchange = function() {
        var fileCount = imageUploader.files.length;
        if (fileCount <= 1) {
            for (var x = 0; x < fileCount; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("main-profile-image").src = url;
                errorReset('update-profile-error-loader', 'profile-update-btn');
            }
        } else {
            showToast("Select only 01 image");
        }
    };
}

var currentTargetTextContent;
var currentInputcontent;
var isFirstEntry = true;

function textLimitIndicate(id, letterCount) {
    var component = document.getElementById(id);
    var targetText = document.getElementById(id + "-text");
    var isVAliedOperation = false;

    if (isFirstEntry) {
        currentTargetTextContent = targetText.innerText;
        isFirstEntry = false;
    }

    if ((letterCount - component.value.length) < 0 || (letterCount - component.value.length) > letterCount) {
        isVAliedOperation = false;
    } else {
        isVAliedOperation = true;
    }

    if (isVAliedOperation) {
        currentInputcontent = component.value;
        targetText.innerHTML = "";

        var finalLetterCount;

        if (component.value.length < 10) {
            finalLetterCount = "0" + component.value.length;
        } else {
            finalLetterCount = component.value.length;
        }

        targetText.innerHTML = currentTargetTextContent + "&nbsp;&#40;" + finalLetterCount + "/" + letterCount + "&#41;";

        if (component.value.length == 0) {
            targetText.innerHTML = "";
            targetText.innerHTML = currentTargetTextContent;
        }
    } else {
        if (component.value.length == 0) {
            targetText.innerHTML = "";
            targetText.innerHTML = currentTargetTextContent;
        } else {
            component.value = currentInputcontent;
        }
    }

}

function userProfileUpdate() {
    var firstName = document.getElementById("profile-first-name");
    var lastName = document.getElementById("profile-last-name");
    var bio = document.getElementById("bio");
    var username = document.getElementById("profile-username");
    var mobile = document.getElementById("profile-mobile");
    var password = document.getElementById("profile-password");
    var imageUploader = document.getElementById("profile-image-uploader");

    var form = new FormData();
    form.append("firstName", firstName.value);
    form.append("lastName", lastName.value);
    form.append("bio", bio.value);
    form.append("username", username.value);
    form.append("mobile", mobile.value);
    form.append("password", password.value);

    if (imageUploader.files.length == 1) {
        form.append("image", imageUploader.files[0]);
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("profile-header-main-name").innerText = firstName.value + " " + lastName.value;
                document.getElementById("profile-header-main-username").innerText = "@" + username.value;
                document.getElementById("update-profile-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> Profile Updated&nbsp;&nbsp;<div class='spinner-border def-modal-spinner' role='status'></div> new settings reload in 03 seconds...</span>";
                setTimeout(pageRedirect, 3000);
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                document.getElementById("update-profile-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("profile-update-btn").disabled = true;
                document.getElementById("profile-update-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "userProfileUpdateProcess.php", true);
    request.send(form);
}

function postContentfieldIncrease() {
    var postContent = document.getElementById("post-content");
    postContent.style.height = "5px";
    postContent.style.height = (postContent.scrollHeight) + "px";
}

function emojiAdder(targetAreaId, emojiDec) {
    var targetArea = document.getElementById(targetAreaId);
    targetArea.value = targetArea.value + emojiDec;
}

var createPostImageCounter = 0;

function createPostImageInclude() {
    var createPostImageUploader = document.getElementById("create-post-image-upload");

    createPostImageUploader.onchange = function() {
        var fileCount = createPostImageUploader.files.length;

        if (fileCount <= 4) {
            if ((createPostImageCounter + fileCount) <= 4) {

                for (var x = 0; x < fileCount; x++) {
                    createPostImageCounter += 1;

                    var file = this.files[x];
                    var url = window.URL.createObjectURL(file);

                    var postImageGenerateArea = document.getElementById("post-image-generate-area");

                    var newImageComponentBox = document.createElement("div");
                    newImageComponentBox.id = "create-post-image-box" + createPostImageCounter;
                    newImageComponentBox.classList = "d-flex flex-row justify-content-center align-items-center create-post-image-box-modify";

                    var newImageComponent = document.createElement("img");
                    newImageComponent.src = url;
                    newImageComponent.alt = "post-img-" + (x + 1);
                    newImageComponent.classList = "img-fluid create-post-def-image";

                    newImageComponentBox.appendChild(newImageComponent);
                    postImageGenerateArea.appendChild(newImageComponentBox);

                    errorReset('create-post-error-loader', 'create-post-btn');
                }

                if (document.getElementById("create-post-image-reset-btn").classList.contains("d-none")) {
                    document.getElementById("create-post-image-reset-btn").classList.toggle("d-none");
                }

            } else {
                document.getElementById("create-post-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> Maximum image count is 04</span>";
                document.getElementById("create-post-btn").disabled = true;
                document.getElementById("create-post-btn").classList.add("disabled-btn");
            }
        } else {
            document.getElementById("create-post-error-loader").innerHTML = "<span class='error-text post-header'>" +
                "<i class='bi bi-info-circle-fill error-text post-header'></i> Maximum image count is 04</span>";
            document.getElementById("create-post-btn").disabled = true;
            document.getElementById("create-post-btn").classList.add("disabled-btn");
        }
    };
}

function createPostImageRemove() {
    isCanResetBtnToggle = true;
    createPostImageCounter = 0;
    document.getElementById("create-post-image-reset-btn").classList.toggle("d-none");
    document.getElementById("post-image-generate-area").innerHTML = "";
    document.getElementById("create-post-image-upload").value = "";
}

function saveNewPost(checkBoxCount) {
    var postHeader = document.getElementById("post-header");
    var postContent = document.getElementById("post-content");
    var createPostCategory = document.getElementById("create-post-category");
    var createPostImageUploader = document.getElementById("create-post-image-upload");

    var fileCount = createPostImageUploader.files.length;

    var form = new FormData();
    form.append("postHeader", postHeader.value);
    form.append("postContent", postContent.value);
    form.append("postCategory", createPostCategory.value);

    if (fileCount <= 4 && fileCount > 0) {
        for (var x = 0; x < fileCount; x++) {
            form.append("image" + x, createPostImageUploader.files[x]);
        }
    }

    var selectedTagsArray = new Array();

    for (var y = 0; y < checkBoxCount; y++) {
        var checkBoxComponent = document.getElementById("create-post-tag" + y);

        if (checkBoxComponent.checked) {
            selectedTagsArray.push(checkBoxComponent.value);
        }
    }
    form.append("selectedTagsArray", JSON.stringify(selectedTagsArray));

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("create-post-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-check-circle-fill error-text post-header'></i> Post published</span>";
                setTimeout(postPublishModalHide, 3000);
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                document.getElementById("create-post-error-loader").innerHTML = "<span class='error-text post-header'>" +
                    "<i class='bi bi-info-circle-fill error-text post-header'></i> " + text + "</span>";
                document.getElementById("create-post-btn").disabled = true;
                document.getElementById("create-post-btn").classList.add("disabled-btn");
            }
        }
    };

    request.open("POST", "saveNewPostProcess.php", true);
    request.send(form);
}

function postPublishModalHide() {
    createPostModalReset();
}

function createPostModalReset() {
    document.getElementById("post-header").value = "";
    document.getElementById("post-content").value = "";
    document.getElementById("post-content-text").innerHTML = "";
    document.getElementById("create-post-category").value = "0";

    createPostImageCounter = 0;
    document.getElementById("post-image-generate-area").innerHTML = "";
    document.getElementById("create-post-image-upload").value = "";

    if (!document.getElementById("create-post-image-reset-btn").classList.contains("d-none")) {
        document.getElementById("create-post-image-reset-btn").classList.toggle("d-none");
    }

    var checkBoxComponentsCount = document.getElementById("create-post-category").childElementCount;

    for (var x = 0; x < checkBoxComponentsCount; x++) {
        document.getElementById("create-post-tag" + x).checked = false;
    }
}

function mainPostPreLoader(srchKy, ctgryKy, tgKy) {
    var mainPostLoadingArea = document.getElementById("main-posts-load-area");

    var mainBoxComponent = document.createElement("div");
    mainBoxComponent.classList = "col-12 main-post-card ps-3 pt-3 pe-3 pb-3 mt-2 d-flex flex-column justify-content-center align-items-center";

    var spinnerComponent = document.createElement("div");
    spinnerComponent.classList = "spinner-border def-modal-spinner mb-1";
    spinnerComponent.setAttribute("role", "status");
    mainBoxComponent.appendChild(spinnerComponent);

    var statusText = document.createElement("span");
    statusText.innerHTML = "Posts loading";
    mainBoxComponent.appendChild(statusText);

    mainPostLoadingArea.innerHTML = "";
    mainPostLoadingArea.appendChild(mainBoxComponent);

    setTimeout(
        function() {
            mainPostLoad(srchKy, ctgryKy, tgKy);
        }, 2000);
}

function mainPostLoad(srchKy, ctgryKy, tgKy) {
    var filePath;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            document.getElementById("main-posts-load-area").innerHTML = text;
        }
    };

    if (!(typeof srchKy === 'undefined' || srchKy === null)) {
        filePath = "mainPostSearchProcess.php?srch_ky=" + srchKy;
    } else if (!(typeof ctgryKy === 'undefined' || ctgryKy === null)) {
        filePath = "mainPostSearchProcess.php?ctgry_ky=" + ctgryKy;
    } else if (!(typeof tgKy === 'undefined' || tgKy === null)) {
        filePath = "mainPostSearchProcess.php?tg_ky=" + tgKy;
    } else {
        filePath = "mainPostSearchProcess.php?";
    }

    request.open("GET", filePath, true);
    request.send();
}

function updateVote(postId, atorMl) {

    var form = new FormData();
    form.append("pstId", postId);
    form.append("atorMl", atorMl);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text == "down vote") {
                var updatedVoteCount = parseInt(document.getElementById("vote-count-text" + postId).innerText) - 1;

                if (updatedVoteCount < 10) {
                    document.getElementById("vote-count-text" + postId).innerHTML = "0" + updatedVoteCount;
                } else {
                    document.getElementById("vote-count-text" + postId).innerHTML = updatedVoteCount;
                }

                document.getElementById("downvote-btn" + postId).innerHTML = "<i class='bi bi-caret-down fs-5'></i>";
                document.getElementById("upvote-btn" + postId).innerHTML = "<i class='bi bi-caret-up fs-5'></i>";
            } else if (text == "up vote") {
                var updatedVoteCount = parseInt(document.getElementById("vote-count-text" + postId).innerText) + 1;

                if (updatedVoteCount < 10) {
                    document.getElementById("vote-count-text" + postId).innerHTML = "0" + updatedVoteCount;
                } else {
                    document.getElementById("vote-count-text" + postId).innerHTML = updatedVoteCount;
                }

                document.getElementById("upvote-btn" + postId).innerHTML = "<i class='bi bi-caret-up-fill fs-5'></i>";
                document.getElementById("downvote-btn" + postId).innerHTML = "<i class='bi bi-caret-down fs-5'></i>";

            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("POST", "updateVoteProcess.php", true);
    request.send(form);
}

function commentLoad(postId) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            document.getElementById("comment-loader").innerHTML = text;
        }
    };

    request.open("GET", "commentLoadProcess.php?pst_id=" + postId, true);
    request.send();
}

function commentSave(postId, atorMl) {
    var commentText = document.getElementById("comment-text");

    var form = new FormData();
    form.append("commentText", commentText.value);
    form.append("pstId", postId);
    form.append("atorMl", atorMl);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                commentText.value = "";
                commentLoad(postId);

                if ((parseInt(document.getElementById("comment-counter-text").innerText) + 1) < 10) {
                    document.getElementById("comment-counter-text").innerHTML = "0" + (parseInt(document.getElementById("comment-counter-text").innerText) + 1);
                } else {
                    document.getElementById("comment-counter-text").innerHTML = parseInt(document.getElementById("comment-counter-text").innerText) + 1;
                }
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("POST", "commentSaveProcess.php", true);
    request.send(form);
}

function deleteComment(cmntId, pstId) {

    var commentText = document.getElementById("comment-text");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text == "success") {
                commentText.value = "";
                commentLoad(pstId);

                if ((parseInt(document.getElementById("comment-counter-text").innerText) - 1) < 10) {
                    document.getElementById("comment-counter-text").innerHTML = "0" + (parseInt(document.getElementById("comment-counter-text").innerText) - 1);
                } else {
                    document.getElementById("comment-counter-text").innerHTML = parseInt(document.getElementById("comment-counter-text").innerText) - 1;
                }
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("GET", "commentDeleteProcess.php?cmnt_id=" + cmntId, true);
    request.send();
}

function commentTextReset() {
    document.getElementById("comment-text").value = "";
}

function privateChatContentLoad(recvrMl) {
    var form = new FormData();
    form.append("recvrMl", recvrMl);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast(text);
            } else {
                document.getElementById("private-chat-content-loader").innerHTML = text;
                shortMessageLoadStop();
                chatContentLoadStarter(recvrMl);
                showModal('modal4');
            }
        }
    };

    request.open("POST", "privateChatContentLoadProcess.php", true);
    request.send(form);
}

function chatAccountLoad() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                document.getElementById("private-chat-error-loader").innerHTML = text;
            } else {
                document.getElementById("short-message-loading-area").innerHTML = text;
            }
        }
    };

    request.open("GET", "chatAccountLoadProcess.php", true);
    request.send();
}

function privateChatLoad(recvrMl) {
    var form = new FormData();
    form.append("recvrMl", recvrMl);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast(text);
            } else {
                document.getElementById("private-chat-loading-area").innerHTML = text;
            }
        }
    };

    request.open("POST", "privateChatLoadProcess.php", true);
    request.send(form);
}

function saveChat(recvrMl) {

    var privateChatText = document.getElementById("private-chat-text");

    var form = new FormData();
    form.append("recvrMl", recvrMl);
    form.append("privateChatText", privateChatText.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text = "success") {
                privateChatText.value = "";
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                document.getElementById("private-chat-error-loader").innerHTML = text;
            }
        }
    };

    request.open("POST", "saveChatProcess.php", true);
    request.send(form);
}

function deletePrivateChat(msgId, recvrMl) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                document.getElementById("private-chat-error-loader").innerHTML = text;
            }
        }
    };

    request.open("GET", "deleteChatProcess.php?msgId=" + msgId, true);
    request.send();
}

var shortMessageLoadStarterId = 0;
var chatContentLoadStarterId = 0;
const messageRefreshDelay = 5000;

function shortMessageLoadStarter() {
    if (shortMessageLoadStarterId == 0) {
        shortMessageLoadStarterId = setInterval(chatAccountLoad, messageRefreshDelay);
    }
}

function shortMessageLoadStop() {
    clearInterval(shortMessageLoadStarterId);
    shortMessageLoadStarterId = 0;
}

function chatContentLoadStarter(recvrMl) {
    if (chatContentLoadStarterId == 0) {
        chatContentLoadStarterId = setInterval(function() {
            privateChatLoad(recvrMl);
        }, messageRefreshDelay);
    }
}

function chatContentLoadStop() {
    clearInterval(chatContentLoadStarterId);
    chatContentLoadStarterId = 0;
}

var messageNotificationCountLoadStarterId = 0;
var notificationCountLoadStarterId = 0;

function messageNotificationCountLoadStarter() {
    if (messageNotificationCountLoadStarterId == 0) {
        messageNotificationCountLoadStarterId = setInterval(messageNotificationCountLoad, messageRefreshDelay);
    }
}

function messageNotificationCountLoad() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast("Something went wrong");
            } else {
                if (text == "00") {
                    if (!document.getElementById("message-notification-count-loader").classList.contains("d-none")) {
                        document.getElementById("message-notification-count-loader").classList.toggle("d-none");
                    }
                } else {
                    if (document.getElementById("message-notification-count-loader").classList.contains("d-none")) {
                        document.getElementById("message-notification-count-loader").classList.toggle("d-none");
                    }
                    document.getElementById("message-notification-count-loader").innerHTML = text;
                }
            }
        }
    };

    request.open("GET", "messageNotificationCountLoadProcess.php", true);
    request.send();
}

function messageNotificationCountLoadStop() {
    clearInterval(messageNotificationCountLoadStarterId);
    messageNotificationCountLoadStarterId = 0;
}

function notificationCountLoadStarter() {
    if (notificationCountLoadStarterId == 0) {
        notificationCountLoadStarterId = setInterval(notificationCountLoad, messageRefreshDelay);
    }
}

function notificationCountLoad() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;

            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast("Something went wrong");
            } else {
                if (text == "00") {
                    if (!document.getElementById("notification-count-loader").classList.contains("d-none")) {
                        document.getElementById("notification-count-loader").classList.toggle("d-none");
                    }
                } else {
                    if (document.getElementById("notification-count-loader").classList.contains("d-none")) {
                        document.getElementById("notification-count-loader").classList.toggle("d-none");
                    }
                    document.getElementById("notification-count-loader").innerHTML = text;
                }
            }
        }
    };

    request.open("GET", "notificationCountLoadProcess.php", true);
    request.send();
}

function notificationCountLoadStop() {
    clearInterval(notificationCountLoadStarterId);
    notificationCountLoadStarterId = 0;
}

var notificationLoadStarterId = 0;

function notificationLoadStarter() {
    if (notificationLoadStarterId == 0) {
        notificationLoadStarterId = setInterval(notificationLoad, messageRefreshDelay);
    }
}

function notificationLoad() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast(text);
            } else {
                document.getElementById("notification-loading-area").innerHTML = text;
            }
        }
    };

    request.open("GET", "notificationLoadProcess.php", true);
    request.send();
}

function notificationLoadStop() {
    clearInterval(notificationLoadStarterId);
    notificationLoadStarterId = 0;
}

function deleteNotification(ntificnId) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else if (text == "Something went wrong") {
                showToast(text);
            }
        }
    };

    request.open("GET", "deleteNotificationProcess.php?ntificn_id=" + ntificnId, true);
    request.send();
}

function allLoadStarterStop() {
    messageNotificationCountLoadStop();
    notificationCountLoadStop();
    notificationLoadStop();
    chatContentLoadStop();
    shortMessageLoadStop();
}

function sendRequestMessage(recvrMl) {

    var form = new FormData();
    form.append("recvrMl", recvrMl);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var text = request.responseText;
            if (text == "success") {
                showToast("Message sent, Check your chat account list");
            } else if (text == "user rejected") {
                setTimeout(showToast("User missing, You can signin & comeback"), 4000);
                setTimeout(pageRedirect, 15000);
            } else {
                showToast(text);
            }
        }
    };

    request.open("POST", "sendRequestMessageProcess.php", true);
    request.send(form);
}

function searchPost() {
    var serachText = document.getElementById("main-search-text");

    if (serachText.value.length > 0) {
        mainPostPreLoader(serachText.value, null, null);
    }
}

function serachBarsValueBalancer(isMiniSearchbarAproch) {
    var serachText1 = document.getElementById("main-search-text");
    var serachText2 = document.getElementById("main-search-text2");

    if (isMiniSearchbarAproch == true) {
        serachText1.value = serachText2.value;
    } else if (isMiniSearchbarAproch == false) {
        serachText2.value = serachText1.value;
    }
}

function clearSearchText() {
    document.getElementById("main-search-text").value = "";
    document.getElementById("main-search-text2").value = "";
    mainPostPreLoader();
}