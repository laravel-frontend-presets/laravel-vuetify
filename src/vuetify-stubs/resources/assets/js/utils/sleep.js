export default (ms) => {
  return new Promise((resolve,reject) => {
    setTimeout(() => {
      resolve()
    }, ms)
  })
}