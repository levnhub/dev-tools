// JS micro & macro

// Bad

let i = 0;
let start = Date.now();

function count() {
  // делаем тяжёлую работу
  for (let j = 0; j < 1e9; j++) {
    i++;
  }
  alert("Done in " + (Date.now() - start) + 'ms');
}

count();

// Good

(function () {

	let i = 0;
	let start = Date.now();

	function count() {
	  // перенесём планирование очередного вызова в начало
	  if (i < 1e9 - 1e6) {
	    setTimeout(count); // запланировать новый вызов
	  }

	  do {
	    i++;
	  } while (i % 1e6 != 0);

	  if (i == 1e9) {
	    alert("Done in " + (Date.now() - start) + 'ms');
	  }
	}

	count();
})();

// with Progress

(function () {
	let i = 0;

	function count() {

	  // сделать часть крупной задачи (*)
	  do {
	    i++;
	    progress.innerHTML = i;
	  } while (i % 1e3 != 0);

	  if (i < 1e7) {
	    setTimeout(count);
	  }

	}

	count();
})();

// Progress with microtask

(function () {
	let i = 0;

  function count() {

    // делаем часть крупной задачи (*)
    do {
      i++;
      progress.innerHTML = i;
    } while (i % 1e3 != 0);

    if (i < 1e6) {
      queueMicrotask(count);
    }

  }

  count();
})();