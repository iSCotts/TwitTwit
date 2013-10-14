

var SPACER = "images/spacer1x1.gif";


function fixPNGs()
{
  var images = document.images;
  var i;

  if (is_ie5_5up && is_win32)
  {
    for (i = 0; i < images.length; i++)
    {
      fixPNG(images[i]);
    }
    setTimeout("showPNGs()", 200);
  }
  else
  {
    for (i = 0; i < images.length; i++)
    {
      images[i].style.visibility = "visible";
    }
  }
}


function fixPNG(element)
{
  if (element.style.visibility == "hidden")
  {
    element.style.filter =
      "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
      element.src + "',sizingMethod='image') " +
      "revealTrans(transition=12,duration=0.5)";
  }
  else
  {
    element.style.filter =
      "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
      element.src + "',sizingMethod='image')";
  }

  element.src = SPACER;
}


function showPNGs()
{
  var images = document.images;
  var i;

  for (i = 0; i < images.length; i++)
  {
    showPNG(images[i]);
  } 
}


function showPNG(element)
{
  if (element.style.visibility == "hidden")
  {
    element.filters[1].Apply();
    element.style.visibility = "visible";
    element.filters[1].Play();
  }
}
