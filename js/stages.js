function Stage(stageName) {
    const $modeSwitch = $('.mode-switch');
    const $getlsDataButton = $('#getlsDataButton');
    const $territorySelection = $('#territory-selection');
    const $accessCodeSelection = $('#access-code-selection');
    const $ivcBase = $('#ivcBase');
    const $accessCodeLs = $('#accessCodeLs');
    const $ivcBaseDetails = $('#ivcBaseDetails');
    const $Ls = $('#Ls');
    const $getLsData = $('#getLsData');
    const $lsData = $('#lsData');
    const $Address = $('#lsAddress');
    const $loader = $('.loader');
    const $payButton = $('#payButton');

    const stages = {
        'Инициализация': () => {
            $ivcBase.val($ivcBase.find('option:first').val());
            $Ls.val('');
            $getLsData.prop('disabled', true);
            $territorySelection.addClass('active');
            $accessCodeSelection.removeClass('active');
            $ivcBase.show();
            $ivcBaseDetails.hide();
            $Ls.show();
            $lsData.hide();
            $lsData.children().hide;
            $getlsDataButton.prop('disabled', true);
            $getlsDataButton.removeClass('active');
            $Address.hide();
            $loader.hide();
            $payButton.prop('disabled', true);
            $payButton.removeClass('active');
            $('#payButton').removeData('summa');
            $('#payButton').text('Оплатить ');
        },
        'Выбран режим по территории': () => {
            $territorySelection.addClass('active');
            $accessCodeSelection.removeClass('active');
            $territorySelection.show();
            $accessCodeSelection.hide();
            $ivcBase.show();
            $ivcBaseDetails.hide();
            $lsData.hide();
            $Address.hide();
            $Ls.prop('disabled', true);
            $getLsData.prop('disabled', true);
            $getlsDataButton.prop('disabled', true);
            $getlsDataButton.removeClass('active');
            $Ls.val('');
            $('#payButton').removeData('summa');
            $('#payButton').text('Оплатить ');
        },
        'Выбран режим по коду доступа': () => {
            $accessCodeSelection.addClass('active');
            $territorySelection.removeClass('active');
            $accessCodeSelection.show();
            $territorySelection.hide();
            $accessCodeLs.show();
            $accessCodeLs.val('970017035729-');
            $ivcBaseDetails.hide();
            $lsData.hide();
            $Address.hide();
            $Ls.prop('disabled', true);
            $getLsData.prop('disabled', true);
            $getlsDataButton.prop('disabled', true);
            $getlsDataButton.removeClass('active');
            $('#payButton').text('Оплатить ');

            $Ls.val('');
            $('#payButton').removeData('summa');
        },
        'Выбрана территория': () => {
            $territorySelection.removeClass('active');
            $accessCodeSelection.removeClass('active');
            $ivcBase.hide();
            $ivcBaseDetails.show();
            $Ls.show();
            $lsData.hide();
            $Address.hide();
            $Ls.prop('disabled', false);
            $getLsData.prop('disabled', false);
            $getlsDataButton.prop('disabled', false);
            $getlsDataButton.addClass('active');
            $('#payButton').removeData('summa');
            $('#payButton').text('Оплатить ');
        },
        'Выбран код доступа': () => {
            //$modeSwitch.prop('disabled', true);
            $territorySelection.removeClass('active');
            $accessCodeSelection.removeClass('active');
            $ivcBase.hide();
            //window.restoreIvcBase = replaceWithPlaceholder($ivcBase);
            $ivcBaseDetails.show();
            $Ls.show();
            $Address.show();
            $lsData.hide();
            $Ls.prop('disabled', false);
            $getLsData.prop('disabled', false);
            $getlsDataButton.prop('disabled', false);
            $getlsDataButton.addClass('active');
            $payButton.prop('disabled', false);
            $payButton.addClass('active');
            $('#payButton').removeData('summa');
            $('#payButton').text('Оплатить ');

        },
        'Детализация': () => {
            //$modeSwitch.prop('disabled', true);
            $territorySelection.removeClass('active');
            $accessCodeSelection.removeClass('active');
            $ivcBase.hide();
            //window.restoreIvcBase = replaceWithPlaceholder($ivcBase);
            $ivcBaseDetails.show();
            $Ls.show();
            $Address.show();
            $lsData.show();
            $Ls.prop('disabled', false);
            $getLsData.prop('disabled', false);
            $getlsDataButton.prop('disabled', false);
            $getlsDataButton.addClass('active');
            $payButton.prop('disabled', false);
            $payButton.addClass('active');
            $('#payButton').removeData('summa');
            $('#payButton').text('Оплатить ');

        }


    };

    stages[stageName]();
}
