#!/usr/bin/env bash

method="$1"
shift

exitIfInvalidExitCode() {
    if [[ $1 -ne 0 ]]
    then
        exit $1
    fi
}

checkNetcat() {
    echo "Checking $3..."

    maxcounter=50
    counter=1

    while ! netcat -z $1 $2 ; do
        sleep 1
        counter=`expr $counter + 1`
        if [ $counter -gt $maxcounter ]; then
            >&2 echo "We have been waiting for $3 too long. Failing."
            exit 1
        fi;
    done

    echo "$3 is up"
}

checkMySQL() {
    checkNetcat $DATABASE_HOST $DATABASE_PORT "MySQL"
}

checkMongoDB() {
    checkNetcat $MONGO_HOST $MONGO_PORT "MongoDB"
}

runMigrations() {
    echo "Running migrations..."

    bin/doctrine-migrations migrate --configuration=/var/www/config/migrations/doctrine-config.php --db-configuration=/var/www/config/migrations/doctrine-db.php --no-interaction

    echo "Migrations run"
}

dependenciesUp() {
    echo "Dependencies up"
    checkMySQL
    checkMongoDB
}

dependenciesDown() {
    echo "Dependencies down"
}

generateCoverage() {
    php bin/phpcov merge build/coverage --html build/coverage/merged/html
    exitIfInvalidExitCode $?
}

functional() {
    dependenciesUp
    runMigrations
    php bin/behat -vvv --suite=functional $*
    exitIfInvalidExitCode $?
    dependenciesDown
}

unit() {
    php bin/phpunit --testsuite=unit --no-coverage $*
    exitIfInvalidExitCode $?
}

functionalCoverage() {
    dependenciesUp
    runMigrations
    php bin/behat --profile=coverage --suite=functional --format=progress $*
    exitIfInvalidExitCode $?
    dependenciesDown
}

unitCoverage() {
    php bin/phpunit --testsuite=unit $*
    exitIfInvalidExitCode $?
}

testAll() {
    unit
    functional
}

testAllCoverage() {
    unitCoverage
    functionalCoverage
    generateCoverage
}

case "$method" in
  all)
    testAll
    ;;
  functional)
    functional $*
    ;;
  unit)
    unit $*
    ;;
  all-coverage)
    testAllCoverage
    ;;
  functional-coverage)
    functionalCoverage $*
    generateCoverage
    ;;
  unit-coverage)
    unitCoverage $*
    generateCoverage
    ;;
  *)
    testAll
esac

exit 0