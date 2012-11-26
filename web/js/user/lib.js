function buildDiplayName(givenName_obj, sn_obj) 
{
    return sprintf("%s %s", sn_obj.val(), givenName_obj.val() );
}

function buildUserName(givenName_obj, sn_obj) 
{
    uid = sprintf("%s%s", substr(sn_obj.val(), 0, 1), givenName_obj.val());
    return uid.toLowerCase();
}

function buildLhsEmailAddress(givenName_obj, sn_obj) 
{
    uid = sprintf("%s.%s", sn_obj.val(), givenName_obj.val());
    return uid.toLowerCase();
}

function buildEmailAddress(lhs_obj, rhs_obj) 
{
    return sprintf("%s@%s", lhs_obj.val(), rhs_obj.val()) ;
}

function checkQuotas(quotahard_obj, quotasoft_obj, quotawarn_obj)
{
    quotahard = ( quotahard_obj.val() * 1 );
    quotasoft = ( quotasoft_obj.val() * 1 );
    quotawarn = ( quotawarn_obj.val() * 1 );

    if ( quotahard <= quotasoft ) return false;
    if ( quotasoft <= quotawarn ) return false;
    if ( quotahard <= quotawarn ) return false;
    return true;
}

function checkQuotasErrorReport(isValid)
{
    if ( ! isValid ) {
        $('#zarafa-quota-hard').addClass('ym-error');
        $('#zarafa-quota-soft').addClass('ym-error');
        $('#zarafa-quota-warn').addClass('ym-error');
        return 'no';
    } else {
        $('#zarafa-quota-hard').removeClass('ym-error');
        $('#zarafa-quota-soft').removeClass('ym-error');
        $('#zarafa-quota-warn').removeClass('ym-error');
        return 'yes';
    }
}

function quotaResetValues()
{
    $('input#zdata_zarafaQuotaHard').val(null);
    $('input#zdata_zarafaQuotaSoft').val(null);
    $('input#zdata_zarafaQuotaWarn').val(null);
    return 1;
}
