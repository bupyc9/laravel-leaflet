import PointIndex from "./components/points/PointIndex";
import CategoryList from "./components/categories/CategoryList";

export default [
    {
        path: "/",
        name: "home",
        component: PointIndex,
    },
    {
        path: "/categories",
        name: "categoryList",
        component: CategoryList,
    },
];