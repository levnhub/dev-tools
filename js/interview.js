// Data copy & Link test

// 1

let a = 'string';
let b = a;
b = 'string2';
console.log(a);  // string

let c = {
	d: 'x1'
}
b = c;
b.d = 'x2';
console.log(c); // x2

// 2

function changeStuff(a, b) {
  a = a * 10;
  b.item = 'changed';
}

let num = 10;
let obj1 = { item: 'unchanged' };

changeStuff(num, obj1);

console.log(num); // 10 (no return)
console.log(obj1.item); // changed (link)

// Context

var radius = 30; // global variable

const shape = {
  radius: 10,
  diameter() {
    return this.radius * 2; // 20
  },
  perimeter: () => {
  	return 2 * this.radius; // context lost (if not a class, get window context)
  },
};

console.log('diameter', shape.diameter()); // 20
console.log('perimeter', shape.perimeter()); // NaN

// Promise

console.log('script start'); // 1

setTimeout(function () {
  console.log('setTimeout'); // 5
}, 0); // (min timeOut === 4 ms)

Promise.resolve()
  .then(function () {
    console.log('promise1'); // 3
  })
  .then(function () {
    console.log('promise2'); // 4
  });

console.log('script end'); // 2

// Async

function delay() {
  return new Promise((resolve) => setTimeout(resolve, 2000));
}

async function delayedLog(item) {
  await delay();
  console.log(item);
}

async function process(array) {
  array.forEach(async (item) => {
    await delayedLog(item);
  });
  console.log('Process completed!'); // 1
}

process([1, 2, 3, 5]); // 2 All items

// 3D+ to 1D array
// [1, [1, 2, [3, 4]], [2, 4]] -> [1, 1, 2, 3, 4, 2, 4]

const multiArray = [1, [1, 2, [3, 4]], [2, 4]];

function doSimpleArray(array) {
	let result = [];
	array.forEach(item => {
		if (item.length) {
			result = result.concat(doSimpleArray(item));
		} else {
			result.push(item);
		}
	})
	return result;
}

const resultArray = doSimpleArray(multiArray);

console.log(resultArray);

// JS micro & macro

// Bad

// let i = 0;
// let start = Date.now();

// function count() {
//   // делаем тяжёлую работу
//   for (let j = 0; j < 1e9; j++) {
//     i++;
//   }
//   alert("Done in " + (Date.now() - start) + 'ms');
// }

// count();

// Good

// (function () {

// 	let i = 0;
// 	let start = Date.now();

// 	function count() {
// 	  // перенесём планирование очередного вызова в начало
// 	  if (i < 1e9 - 1e6) {
// 	    setTimeout(count); // запланировать новый вызов
// 	  }

// 	  do {
// 	    i++;
// 	  } while (i % 1e6 != 0);

// 	  if (i == 1e9) {
// 	    alert("Done in " + (Date.now() - start) + 'ms');
// 	  }
// 	}

// 	count();
// })();

// with Progress

// (function () {
// 	let i = 0;

// 	function count() {

// 	  // сделать часть крупной задачи (*)
// 	  do {
// 	    i++;
// 	    progress.innerHTML = i;
// 	  } while (i % 1e3 != 0);

// 	  if (i < 1e7) {
// 	    setTimeout(count);
// 	  }

// 	}

// 	count();
// })();

// Progress with microtask

// (function () {
// 	let i = 0;

//   function count() {

//     // делаем часть крупной задачи (*)
//     do {
//       i++;
//       progress.innerHTML = i;
//     } while (i % 1e3 != 0);

//     if (i < 1e6) {
//       queueMicrotask(count);
//     }

//   }

//   count();
// })();

// Async in while

(function () {
	var i = 10;
	// while doesn't wait for timeOut
	while (--i) {
		setTimeout(function() {
			console.log('whileTimeOut', i); // Ten zeroes in finish
		});
	}
})();

// Object property lost

(function () {
	var o = {
		a: true,
		f: function () {
			return typeof this.a;
		}
	};

	var x = o.f; // a lost
	console.log(o.a, x()); // true 'undefined' 
})();

// Data types

(function () {
	const o = {};
	const a = [];
	const d = new Date();
	const n = null;

	console.log('datatype', o == a); // false
	console.log('datatype', o === a); // false
	console.log('datatype', typeof o == typeof a); // true
	console.log('datatype', typeof o === typeof a); // true
	console.log('datatype', typeof d === typeof a); // true
	console.log('datatype', typeof n === typeof a); // true
	console.log('datatype', typeof NaN); // number
	console.log('datatype', d instanceof Date); // true
	console.log('datatype', d instanceof Object); // true
	console.log('datatype', a instanceof Array); // true
	console.log('datatype', a instanceof Object); // true
	console.log('datatype', n instanceof Object); // false
})()






