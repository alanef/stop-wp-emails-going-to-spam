import gulp from 'gulp';
import zip from 'gulp-zip';
import del from 'del';
import rename from 'gulp-rename';
import gutil from 'gulp-util';
import dirSync from 'gulp-directory-sync';
const project = 'stop-wp-emails-going-to-spam'; // Project Name.


import { exec } from 'child_process';

gulp.task('translate', (cb) => {
    exec(' wp i18n make-pot ./stop-wp-emails-going-to-spam  ./stop-wp-emails-going-to-spam/languages/stop-wp-emails-going-to-spam.pot --skip-audit --exclude=\'./vendor\'', (err, stdout, stderr) => {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});


gulp.task('zip', (done) => {
    gulp.src('dist/**/*')
        .pipe(rename(function (file) {
            file.dirname = `${project}/${file.dirname}`;
        }))
        .pipe(zip(`${project}.-free.zip`))
        .pipe(gulp.dest('zipped'));
    done();
});


gulp.task('clean', () => {
    return del([
        'dist/components'
    ]);
});

gulp.task('sync', () => {
    return gulp.src('.', {allowEmpty: true})
        .pipe(dirSync('stop-wp-emails-going-to-spam', 'dist', {printSummary: true}))
        .on('error', gutil.log);
});


gulp.task('build', gulp.series('sync', 'clean', 'zip'));





