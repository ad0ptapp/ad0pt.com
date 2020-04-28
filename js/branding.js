for(var a of document.getElementsByTagName("a")) {
	if(a.title == "Hosted on free web hosting 000webhost.com. Host your own website for FREE.") {
		a.parentNode.remove();
	}
}