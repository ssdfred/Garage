TEMPFILE=`mktemp`
trap "rm -rf $TEMPFILE" EXIT

SECRET_KEYS=`fly secrets list -a $1 | tail -n +2 | cut -f1 -d" "`
fly ssh console -a $1 -C env | tr -d '\r' > $TEMPFILE

for key in $SECRET_KEYS; do
  PATTERN="${PATTERN}\|${key}"
done

grep $PATTERN $TEMPFILE | fly secrets import -a $2
if [ $# -gt 0 ]; then
    # If we passed a command, run it as root
    exec "$@"
else
    exec /init