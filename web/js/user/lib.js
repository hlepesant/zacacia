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
