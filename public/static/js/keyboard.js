//將這裡的值改成自己textarea的id
$textarea = '#content';

$(document).delegate($textarea,'keydown',function(e) {
	var keyCode = e.keyCode || e.which;
	//取得光標位置下標
	let start = this.selectionStart;
	let end = this.selectionEnd;

	if(e.shiftKey && keyCode===9){
		//e.preventDefault()必須放在判斷式內部，否則所有鍵盤事件都將無法作用
		e.preventDefault();
		if(start!==end){
			/*
				@proGu
				為了因應多數使用者不會從文字之前開始選取字段的情況，
				必須自動在反縮排快速鍵被按下之後之後自動將起始位置推到textarea同一行的最左側
			*/
			let backIndex = start - 1;
			while(backIndex>=0 && $(this).val().charAt(backIndex)==='\t'){
				backIndex--;
			}
			start = backIndex + 1;
			const txt = $(this).val().substring(start,end).split('\n').map(line=>line.replace(/^\t/, '')).join('\n');
			$(this).val($(this).val().substring(0,start) + txt + $(this).val().substring(end));
			//然後再把光標移到新增的\t後面
			this.selectionStart = start;
			this.selectionEnd = start + txt.length;
		}
	}else if(keyCode==9){
		e.preventDefault();
		if(start===end){
			//在光標前加入\t，再把光標後的文字放到\t後
			$(this).val($(this).val().substring(0,start) + "\t" + $(this).val().substring(end));
			//然後再把光標移到新增的\t後面
			this.selectionStart = this.selectionEnd = start + 1;
		}else{
			//在每行的開頭插入\t再合併起來
			const txt = $(this).val().substring(start,end).split('\n').map(line=>line.replace(/^/,"\t")).join('\n');
			$(this).val($(this).val().substring(0,start) + txt + $(this).val().substring(end));
			this.selectionStart = start;
			this.selectionEnd = start + txt.length;
		}
	}
});

/*顏色選擇器*/
// var colorWell;
// var defaultColor = "#0000ff";
// window.addEventListener("load", startup, false);

// function startup() {
// 	colorWell = document.querySelector("#colorWell");
// 	colorWell.value = defaultColor;
// 	colorWell.addEventListener("input", updateFirst, false);
// 	colorWell.addEventListener("change", updateAll, false);
// 	colorWell.select();
// }

// function updateFirst(event) {
// 	var p = document.querySelector("#test");
// 	if (p) {
// 		p.style.color = event.target.value;
// 	}
// }

// function updateAll(event) {
// 	document.querySelectorAll("#test").forEach(function(p) {
// 		addCircum('font',' color="'+event.target.value+'"');
// 	});
// }

/*各個快速鍵配置*/
document.onkeydown = keydown;

function keydown(evt) {
	if (!evt) evt = event;
	if(evt.altKey){
		switch(evt.keyCode){
			case 66://b
				insEnt('<br />');
				break;
			case 84://t
				insEnt('&emsp;');
				break;
			case 78://n
				insEnt('&nbsp;');
				break;
			case 73://i
				insEnt(' title=""');
				break;
			case 74://j
				insEnt(' class=""');
				break;
			case 81://q
				addCircum('blockquote');
				break;
			case 80://p
				addCircum('p');
				break;
			case 85://u
				addCircum('ul');
				break;
			case 79://o
				addCircum('ol');
				break;
			case 76://l
				addCircum('li');
				break;
			case 67://c
				addCircum('code');
				break;
			case 68://d
				evt.preventDefault();
				addCircum('div');
				break;
			case 70://f
				evt.preventDefault();
				addCircum('font');
				break;
			case 65://a
				addCircum('a',' href=""',9);
				break;
		}
	}
}

function typeinput(char) {
	var char = char;
	let textArea = $($textarea);
	let start = textArea[0].selectionStart;
	let end = textArea[0].selectionEnd;
	let value = textArea[0].value;
	value = value.slice(0, start) + char + value.slice(end);
	textArea[0].value = value;
	textArea[0].focus();
	textArea[0].selectionStart = textArea[0].selectionEnd = start + 1;
}

function addCircum(circumfix,prop,ptr){
	let textArea = $($textarea);
	let start = textArea[0].selectionStart;
	let end = textArea[0].selectionEnd;
	let cont = ((start==end && end==0)?"\n\t\n":textArea.val().substring(start,end));
	let property = (typeof prop!=='undefined'?prop:"");
	let replacement = '<' + circumfix + property + '>' + cont + '</' + circumfix + '>';
	textArea.val(textArea.val().substring(0,start) + replacement + textArea.val().substring(end,textArea.val().length));
	textArea.focus();
	console.log(circumfix.length+property.length);
	let newptr = (start==end && start==0?circumfix.length + 4:circumfix.length + (property?property.length:0) + 2);
	let pointer = (typeof ptr!=='undefined'?ptr:newptr);
	textArea[0].selectionStart = textArea[0].selectionEnd = start + pointer;
}

function insEnt(entity){
	let textArea = $($textarea);
	let start = textArea[0].selectionStart;
	let end = textArea[0].selectionEnd;
	let value = textArea[0].value;
	value = value.slice(0,start) + entity + value.slice(end);
	textArea.val(value);
	textArea.focus();
	textArea[0].selectionStart = textArea[0].selectionEnd = (start + entity.length);
}

function addCF(color){
	addCircum('font',' color="'+color+'"');
}

function insertImg(){
	let textArea = $($textarea);
	let start = textArea[0].selectionStart;
	let end = textArea[0].selectionEnd;
	let value = textArea[0].value;
	value = value.slice(0, start) + '<img src="" alt="" title="" border="">' + value.slice(end);
	textArea[0].value = value;
	textArea[0].focus();
	textArea[0].selectionStart = textArea[0].selectionEnd = start + 10;
}