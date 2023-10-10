// Debounce

const fetchUrl = (url) => {
  console.log(`fetching ${url}...`);
};

function debounce(fn, delay) {
  let timer;
  return function () {
    if (timer) {
      clearTimeout(timer);
    }

    timer = setTimeout(() => {
      fn.apply(this, args); // TODO
    }, delay);
  };
}

const fetching = debounce(fetchUrl, 300);

fetching(1);
fetching(2);
fetching(3);
fetching(4);
fetching(5);
