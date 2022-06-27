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

// Numbers

console.log('number', 1231321..toString()); // '1231321'
console.log('number', 0.1 + 0.2 == 0.3); // false 
console.log('number', 0.1 + 0.2); // 0.30000000000000004
console.log('number', (0.1 + 0.2).toFixed(2)); // 0.30
console.log('number', +(0.1 + 0.2).toFixed(2)); // 0.3
console.log('number', 9999999999999999 ); // 10000000000000000
console.log('number', isNaN(NaN) ); // true
console.log('number', isNaN("str") ); // true
console.log('number', NaN === NaN ); // false
console.log('number', Object.is(NaN, NaN) ); // true
console.log('number', 0 === -0 ); // true
console.log('number', Object.is(0, -0) ); // false

// Bools

console.log(Boolean(function(){})); // true
console.log(Boolean(/foo/)); // true
console.log(Boolean(0)); // false
console.log(Boolean('')); // false
console.log(Boolean('0')); // true

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

// object sort
(function function_name(argument) {
	const list = [
	  { color: 'white', size: 'XXL' },
	  { color: 'red', size: 'XL' },
	  { color: 'black', size: 'M' }
	]

	list.sort((a, b) => (a.color > b.color) ? 1 : -1)

	console.log('sort', list); // ...black, red, white
})();

// Time compare

console.log('time_compare', '2022-11-20T16:30:00+03:00' > '2022-11-20T14:00:01+03:00'); // true

// Context return

(function () {

	var o = {
	  x: 10,
	  foo() {
	        for (let i = 0; i < 10; i++) {
	            setTimeout(() => { // arrow function for context return
	                console.log('Timeout context', i + this.x);
	            }, 0);
	        }
	  }
	}

	o.foo();

})();

// Code result order 

(function () {

	const title = 'Code result order';

	const bar = () => console.log('Timeout');
	const baz = () => console.log('Last');

	const foo = () => {
	   console.log('First'); // 1
	   setTimeout(bar, 0); // 4
	   Promise.resolve().then(() => console.log('Promise')); // 3
	   baz(); // 2
	};

	foo();
})();

//// ASYNC

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

// Promise

console.log('script start'); // 1

setTimeout(function () {
  console.log('setTimeout'); // 5
}, 0); // (min timeOut === 4 ms, becouse this go to end of Event Loop

Promise.resolve()
  .then(function () {
    console.log('promise1'); // 3
  })
  .then(function () {
    console.log('promise2'); // 4
  });

console.log('script end'); // 2

// Promise types

function myPromise(promiseTitle) {
	return new Promise((resolve, reject) => {
		setTimeout(function() {
			resolve(`${promiseTitle} is ok!`);
		}, 900);
	})
}

myPromise('myPromiseFunction').then((response) => {
	console.log(response);
});

Promise.resolve('Short promise').then(res => console.log(res));

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

// Async setTimeout

(function () {
	
	arr = [23, 45, 23, 76, 21];

	arr.forEach((item, index) => {
		setTimeout(function() {
			console.log('Timeout Count', index);
		}, 1000 * index);
	});
	
})();
