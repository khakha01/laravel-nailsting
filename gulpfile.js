import gulp from "gulp";
import sass from "gulp-sass";
import cleanCSS from "gulp-clean-css";
import concat from "gulp-concat";
import rename from "gulp-rename";
import sassPackage from "sass";

const compileSass = sass(sassPackage);

// Task SCSS chung
gulp.task("scss", function () {
    return gulp
        .src(["public/scss/**/*.scss", "!public/scss/admin/**/*.scss"])
        .pipe(compileSass().on("error", compileSass.logError))
        .pipe(concat("style.css"))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: ".min" }))
        .pipe(gulp.dest("public/css"));
});

// Task SCSS cho admin
// gulp.task("scss-admin", function () {
//     return gulp
//         .src("public/scss/admin.scss")
//         .pipe(compileSass().on("error", compileSass.logError))
//         .pipe(cleanCSS())
//         .pipe(rename({ basename: "admin", suffix: ".min" }))
//         .pipe(gulp.dest("public/css"));
// });

// Watch task
gulp.task("watch", function () {
    gulp.watch(
        ["public/scss/**/*.scss", "!public/scss/admin/**/*.scss"],
        gulp.series("scss")
    );
    // gulp.watch(
    //     ["public/scss/admin.scss", "public/scss/admin/**/*.scss"],
    //     gulp.series("scss-admin")
    // );
});

// Default task
//gulp.task("default", gulp.series("scss", "scss-admin", "watch"));
gulp.task("default", gulp.series("scss",  "watch"));
