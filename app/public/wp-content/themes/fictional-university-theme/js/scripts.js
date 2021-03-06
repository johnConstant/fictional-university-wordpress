import "../css/style.css"

// Our modules / classes
import MobileMenu from "./modules/MobileMenu"
import HeroSlider from "./modules/HeroSlider"
import GoogleMap from "./modules/GoogleMap"
import GMap from "./modules/GoogleMap"
import Search from "./modules/Search"
import MyNotes from "./modules/MyNotes"
import Like from "./modules/ProfessorLikes"

// Instantiate a new object using our modules/classes
const mobileMenu = new MobileMenu();
const heroSlider = new HeroSlider();
const googleMap = new GMap();
const search = new Search();
const myNotes = new MyNotes();
const professorLike = new Like();

// Allow new JS and CSS to load in browser without a traditional page refresh
if (module.hot) {
  module.hot.accept()
}
