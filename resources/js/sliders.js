// import EmblaCarousel from 'embla-carousel'
// import Autoplay from 'embla-carousel-autoplay'

// const dotsNode = emblaNode.querySelector('.embla__dots')
// const emblaNode = document.querySelector('.embla')
// const options = { loop: false }
// const plugins = [Autoplay()]
// const emblaApi = EmblaCarousel(emblaNode, options, plugins)

import EmblaCarousel from 'embla-carousel'
import Autoplay from 'embla-carousel-autoplay'
const plugins = [Autoplay()]
import { addDotBtnsAndClickHandlers } from './EmblaCarouselDotButton'

const OPTIONS = { loop: true }

const emblaNode = document.querySelector('.embla')
const viewportNode = emblaNode.querySelector('.embla__viewport')
const dotsNode = emblaNode.querySelector('.embla__dots')

const emblaApi = EmblaCarousel(viewportNode, OPTIONS, plugins)

const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(
  emblaApi,
  dotsNode
)

emblaApi.on('destroy', removeDotBtnsAndClickHandlers)