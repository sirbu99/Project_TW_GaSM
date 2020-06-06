function revealInfo(divName) {
	Array.from(document.getElementsByClassName("recycleElement")).forEach((item) => {
		item.style.display="none";
	})
	Array.from(document.getElementsByClassName(divName)).forEach((item) => {
		item.style.display="block";
	})
}
function showInfo(divName) {
	Array.from(document.getElementsByClassName("recycleElement")).forEach((item) => {
		item.style.display="none";
	})
	Array.from(document.getElementsByClassName(divName)).forEach((item) => {
		item.style.display="flex";
	})
}

