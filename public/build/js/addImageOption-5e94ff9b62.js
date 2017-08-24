function jqAddImageOption(config) {
    this.initDom(config);
    this.bindEvents();
}

jqAddImageOption.prototype.extendOptions = function (config) {
    var defaults = {
        /**
         * DOM of option
         */
        wrapperPoll: '.poll-option',
        btnChooseImage: '.upload-photo',
        parentOption: '.form-group',
        thumbImageOption: '.preview-image',
        elParentOption: '',

        srcThumbImageOption: '',
        elBtnChooseImage: '',
        messages: 'div[data-poll]',

        /**
         * DOM of win-frame option to add image that by link or upload file
         */
        frImage: "#frame-upload-image",
        frUploadFile: '.photo-tb-upload',
        frPreImage: '.img-pre-option',
        frAddImgLink: '.add-image-by-link',
        frInputText: '.photo-tb-url-txt',
        frDelPhoto: '.photo-tb-del',
        frConfirmYes: '.btn-yes',
        frInputFileTemp: '.fileImgTemp',
        frContentError : '.error-win-img',
    }
    var options = $.extend(defaults, config);

    return options;
}

jqAddImageOption.prototype.initDom = function (config) {
    var options = this.extendOptions(config);

    this.wrapperPoll = options.wrapperPoll;
    this.btnChooseImage = options.btnChooseImage;
    this.parentOption = options.parentOption;
    this.thumbImageOption = options.thumbImageOption;
    this.elParentOption = options.elParentOption;

    this.srcThumbImageOption = options.srcThumbImageOption;
    this.elBtnChooseImage = options.elBtnChooseImage;

    // Object Message For Client
    this.messages = $(options.messages).data(options.messages.match(/div\[data-(.*)\]/)[1]).message;

    this.frUploadFile = options.frUploadFile;
    this.frImage = options.frImage;
    this.frPreImage = options.frPreImage;
    this.frAddImgLink = options.frAddImgLink;
    this.frInputText = options.frInputText;
    this.frDelPhoto = options.frDelPhoto;
    this.frConfirmYes = options.frConfirmYes;
    this.frInputFileTemp = options.frInputFileTemp;
    this.frContentError = options.frContentError;
    this.frInputHiddenTemp = '';
    this.addByLink = false;
}

jqAddImageOption.prototype.bindEvents = function () {
    $(this.wrapperPoll).on('click', this.btnChooseImage, this.showIframe.bind(this));
    $(this.frUploadFile).on('click', this.showBoxUpload.bind(this));
    $(this.frInputFileTemp).on('change', this.preImage.bind(this));
    $(this.frAddImgLink).on('click', this.addImageByLink.bind(this));
    $(this.frDelPhoto).on('click', this.delPhoto.bind(this));
    $(this.frConfirmYes).on('click', this.confirmYes.bind(this));
    $(this.wrapperPoll).on('click', this.thumbImageOption, this.editPhoto.bind(this));
}

jqAddImageOption.prototype.addImageByLink = function () {
    var urlImage = $(this.frInputText).val().trim();

    if (urlImage == '') {
        this.showMessage(this.messages.empty_link_image);

        return;
    }

    if (!this.checkExtensionImage(urlImage)) {
        this.showMessage(this.messages.not_type_url_image);

        return;
    }

    this.checkTimeLoadImage(urlImage, function (result) {
        if (result == 'success') {
            this.removeMessage();

            var idOption = this.elParentOption.attr('id');
            var inputUrlText = $('<input>').attr({
                type: 'hidden',
                name: 'optionImage[' + idOption + ']',
                value: ''
            });

            if (this.elParentOption.find('input[type=hidden]').length) {
                this.elParentOption.find('input[type=hidden]').remove();
            }

            this.elParentOption.prepend(inputUrlText);
            this.frInputHiddenTemp = urlImage;
            this.addByLink = true;
            $(this.frInputFileTemp).val('');
            $(this.frPreImage).attr('src', urlImage);
            $(this.frInputText).val('');

        } else if (result == 'error') {
            this.showMessage(this.messages.not_type_url_image);
        } else {
            this.showMessage(this.messages.time_out_url_image);
        }
    }.bind(this));
}

jqAddImageOption.prototype.showMessage = function (message) {
    $(this.frContentError).text(message).show();
}

jqAddImageOption.prototype.removeMessage = function (message) {
    $(this.frContentError).text('').hide();
}

jqAddImageOption.prototype.editPhoto = function (e) {
    var $this = e.currentTarget;
    var srcThumImg = $($this).prop('src');
    this.setSrcFramePhoto(srcThumImg);
    $(this.frImage).modal('show');
}

jqAddImageOption.prototype.setSrcFramePhoto = function (srcImg) {
    this.removeMessage();
    $(this.frPreImage).attr('src', srcImg);
    $(this.frInputText).val('');
}

jqAddImageOption.prototype.delPhoto = function () {
    console.log($(this.frInputFileTemp));
    $(this.frPreImage).attr('src', '');
    $(this.frInputFileTemp).val('');
    $(this.frInputText).val('');
    this.removeMessage();
    this.frInputHiddenTemp = '';
}

jqAddImageOption.prototype.confirmYes = function () {
    var srcPreImage = $(this.frPreImage).attr('src');
    var elThumbImg = this.elParentOption.find('img');
    if (srcPreImage != '') {
        elThumbImg.attr('src', srcPreImage).show();
        if (this.addByLink) {
            this.elParentOption.find('input[type=hidden]').val(this.frInputHiddenTemp);
            $(this.elParentOption).find('input[type=file]').remove();
            $(this.frInputFileTemp).val('');
        } else {
            var elCloneInputFile = $(this.frInputFileTemp).clone();
            var idOption = this.elParentOption.attr('id');
            elCloneInputFile.attr({
                name: 'optionImage[' + idOption + ']',
                class : 'file',
                style : ''
            }).removeAttr('style');
            $(this.elParentOption).find('input[type=file]').remove();
            $(this.elParentOption).find('input[type=hidden]').remove();
            $(this.elParentOption).prepend(elCloneInputFile);
            this.frInputHiddenTemp = '';
        }
    } else {
        $(this.elParentOption).find('input[type=file]').val('');
        $(this.elParentOption).find('input[type=hidden]').val('');
        elThumbImg.hide();
    }

    $(this.frImage).modal('hide');
}

jqAddImageOption.prototype.showIframe = function (e) {
    var $this = e.currentTarget;

    this.removeMessage();
    this.elParentOption = $($this).closest(this.parentOption);
    this.srcThumbImageOption = this.elParentOption.find('img').attr('src');

    if (this.srcThumbImageOption.length) {
        this.setSrcFramePhoto(this.srcThumbImageOption);
    } else {
        $(this.frPreImage).attr('src', '');
    }

    $(this.frImage).modal('show');
}

jqAddImageOption.prototype.showBoxUpload = function (e) {
    $(this.frInputFileTemp).click();
}

jqAddImageOption.prototype.preImage = function (e) {

    var $this = this;
    var input = $($this.frInputFileTemp)[0];

    this.addByLink = false;

    if (this.checkExtensionImage(input.value)) {
        this.removeMessage();

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $($this.frPreImage).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    } else {
        this.showMessage(this.messages.image);
    }
}

jqAddImageOption.prototype.checkTimeLoadImage = function(url, callback, timeout) {
    var timeout = timeout || 5000;
    var timedOut = false, timer;
    var img = new Image();

    img.onerror = img.onabort = function() {
        if (!timedOut) {
            clearTimeout(timer);
            callback("error");
        }
    };

    img.onload = function() {
        if (!timedOut) {
            clearTimeout(timer);
            callback("success");
        }
    };

    img.src = url;

    timer = setTimeout(function() {
        timedOut = true;
        callback("timeout");
    }, timeout);
}

jqAddImageOption.prototype.checkExtensionImage = function (value) {
    var extension = value.substring(value.lastIndexOf('.') + 1).toLowerCase();
    var ruleExtension = ['gif', 'png', 'bmp', 'jpeg', 'jpg'];

    if (ruleExtension.indexOf(extension) > -1) {
        return true;
    }

    return false;
}

//# sourceMappingURL=addImageOption.js.map
