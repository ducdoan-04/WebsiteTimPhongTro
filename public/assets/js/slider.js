const listImage = document.querySelector('.list-images')
const imgs = document.querySelectorAll('.info-images');
const btnLeft = document.querySelector('.btn-left')
const btnRight = document.querySelector('.btn-right')
const length = imgs.length
let current = 0

const handleChangeSlide = () => {
    if (current == length - 1) {
        current = 0
        let width = imgs[0].offsetWidth
        listImage.style.transform = `translateX(0px)`
            // console.log(width)

        // document.querySelector('.active').classList.remove('active')
        // document.querySelector('.index-item-' + current).classList.add('active')

    } else {
        current++
        let width = imgs[0].offsetWidth
        listImage.style.transform = `translateX(${width * -1 * current}px)`
            // document.querySelector('.active').classList.remove('active')
            // document.querySelector('.index-item-' + current).classList.add('active')
    }

}
let handleEventChangeSlide = setInterval(handleChangeSlide, 3000)

btnRight.addEventListener('click', () => {
    clearInterval(handleEventChangeSlide)
    handleChangeSlide()
    handleEventChangeSlide = setInterval(handleChangeSlide, 3000)
})

btnLeft.addEventListener('click', () => {
    clearInterval(handleEventChangeSlide)

    if (current == 0) {
        current = length - 1
        let width = imgs[0].offsetWidth
        listImage.style.transform = `translateX(${width * -1 * current}px)`

    } else {
        current--
        let width = imgs[0].offsetWidth
        listImage.style.transform = `translateX(${width * -1 * current}px)`
            // console.log(width)
    }
    handleEventChangeSlide = setInterval(handleChangeSlide, 3000)
})