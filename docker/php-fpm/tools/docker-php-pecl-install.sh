#!/usr/bin/env bash

EXTS=()
OPTS=()
i=-1
TEMP_DIR=$(pecl config-get temp_dir)
EXT_DIR="/usr/src/php/ext"
INSTALLED=""

docker-php-source extract

for ARG in ${@}
do
    if ! echo "${ARG}" | grep -i -q "^\-\-[a-z]\+[a-z0-9\-]*\=\?[^ ]*$"
    then
        i=$(($i + 1))
        EXTS[$i]=${ARG}
        OPTS[$i]=""
    else
        OPTS[$i]="${OPTS[${i}]} ${ARG}"
    fi
done

for (( j=0; j<=$i; j++ ))
do
    EXT=${EXTS[${j}]}
    OPT=${OPTS[${j}]}

    if [ -d "${EXT_DIR}/${EXT}" ];
    then
        echo "INSTALL SOURCE EXTENSION"
        echo "${EXT}"

        docker-php-ext-install ${EXT}
    else
        if [ "${OPT}" == "" ];
        then
            echo "INSTALL PECL EXTENSION"
            echo "${EXT}"

            pecl install ${EXT}  > /dev/null 2>&1
        else
            echo "INSTALL PECL EXTENSION WITH CUSTOM FLAGS"
            echo "${EXT} ${OPT}"

            pecl install --nobuild ${EXT} > /dev/null 2>&1 && \
            cd "${TEMP_DIR}/${EXT}" > /dev/null 2>&1 && \
            phpize  > /dev/null 2>&1 && \
            ./configure ${OPT}  > /dev/null 2>&1 && \
            make -j$(nproc)  > /dev/null 2>&1 && \
            make install > /dev/null 2>&1
            cd /tmp/
        fi
    fi

    INSTALLED="${INSTALLED} ${EXT}"
done
docker-php-ext-enable ${INSTALLED}

docker-php-source delete