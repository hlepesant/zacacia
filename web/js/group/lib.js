function buildLhsEmailAddress(cn_obj) 
{
    uid = sprintf("%s", cn_obj.val());
    return uid.toLowerCase();
}

function buildEmailAddress(lhs_obj, rhs_obj) 
{
    return sprintf("%s@%s", lhs_obj.val(), rhs_obj.val()) ;
}
