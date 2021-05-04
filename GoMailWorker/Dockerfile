FROM golang:1.16-alpine as builder

WORKDIR /app

COPY . .

ENV CGO_ENABLED=0

RUN go build main.go -o build/worker

FROM apline:3.19

WORKDIR /app

ENV PORT=3000

COPY --from=builder /app/build/worker .

CMD ["./worker"]
