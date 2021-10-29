
const async_await = {

  safeAwait(promise, finallyFunc) {
    return promise
      .then(data => {
        if (data instanceof Error) {
          throwNative(data);
          return [data];
        }
        return [undefined, data];
      })
      .catch(error => {
        throwNative(error);
        return [error];
      })
      .finally(() => {
        if (finallyFunc && typeof finallyFunc === 'function') {
          finallyFunc();
        }
      });
  }
}

export default async_await