'use strict';

const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const gutil = require('gulp-util');
const fs = require('fs');
const path = require('path');

const wp_domain = 'tabula.local'

function browserSyncReload(done) {
    browserSync.reload();
    done();
}

function style() {
    return gulp.src("../assets/scss/theme.scss")
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .pipe(rename({basename: 'theme'}))
        .pipe(gulp.dest("./../assets/css"))
        .pipe(browserSync.stream());
}

function blocksStyles(){
    return gulp
        .src('./../blocks/**/*.scss')
        .pipe(sass({outputStyle: 'compressed', errorLogToConsole: true}))
        .pipe(gulp.dest('./../blocks'));
}

function serve() {
    browserSync.init({
        proxy: "http://" + wp_domain,
        notify: false,
        ui: false,
        open: false
    });
    gulp.watch("./../**/*.php", gulp.series('browserSyncReload'));
    gulp.watch("./../assets/scss/**/*.scss", gulp.series('style', 'browserSyncReload'));
    gulp.watch("./../blocks/**/*.scss", gulp.series('blocksStyles', 'browserSyncReload'));
}

function createNewBlock(done) {
    const blockName = gutil.env.name;

    if (!blockName) {
        console.log('Error: Block name is required. Use --name=<block_name>');
        done();
        return;
    }

    const blockPath = path.join(__dirname, './../blocks', blockName);
    const templateDir = path.join(__dirname, './block_template_files');
    const templateJsonPath = path.join(templateDir, 'block.json');
    const templateFieldsPath = path.join(templateDir, 'fields.php');
    const templatePhpPath = path.join(templateDir, 'template.php');

    const newBlockJsonPath = path.join(blockPath, 'block.json');
    const newBlockFieldsPath = path.join(blockPath, 'fields.php');
    const newBlockPhpPath = path.join(blockPath, 'template.php');
    const newBlockStylePath = path.join(blockPath, 'style.scss');

    if (!fs.existsSync(blockPath)) {
        fs.mkdirSync(blockPath);
        console.log(`Block "${blockName}" created successfully.`);
    } else {
        console.log(`Error: Block "${blockName}" already exists.`);
        done();
        return;
    }

    if (fs.existsSync(templateJsonPath)) {
        let blockJson = fs.readFileSync(templateJsonPath, 'utf8');
        const formattedTitle = blockName
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');

        blockJson = blockJson.replace('$block-slug', blockName);
        blockJson = blockJson.replace('$block-title', formattedTitle);

        fs.writeFileSync(newBlockJsonPath, blockJson);
        console.log(`File "block.json" created and updated successfully in block "${blockName}".`);
    } else {
        console.log('Error: Template block.json not found.');
    }

    if (fs.existsSync(templateFieldsPath)) {
        fs.copyFileSync(templateFieldsPath, newBlockFieldsPath);
        console.log(`File "fields.php" copied successfully to block "${blockName}".`);
    } else {
        console.log('Error: Template fields.php not found.');
    }

    if (fs.existsSync(templatePhpPath)) {
        let blockPhp = fs.readFileSync(templatePhpPath, 'utf8');
        blockPhp = blockPhp.replace(/block-class/g, blockName);
        fs.writeFileSync(newBlockPhpPath, blockPhp);
        console.log(`File "template.php" created and updated successfully in block "${blockName}".`);
    } else {
        console.log('Error: Template template.php not found.');
    }

    const styleContent = `@import "../../assets/scss/include-media";
@import "../../assets/scss/variables";

.${blockName} {

}`;
    fs.writeFileSync(newBlockStylePath, styleContent);
    console.log(`File "style.scss" created successfully in block "${blockName}".`);

    done();
}


exports.serve = serve;
exports.style = style;
exports.blocksStyles = blocksStyles;
exports.createNewBlock = createNewBlock;