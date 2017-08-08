function removeLightBox()
{
    $("div[class=lbtBody]").html("");
    $("span[class=lbtStatus]").html("");
    $("div[id=lightBox]").fadeOut();
}